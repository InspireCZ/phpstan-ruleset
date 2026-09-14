<?php declare(strict_types = 1);

namespace Inspire\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Mirrors Nette\Bridges\ApplicationDI\ApplicationExtension::checkPresenter(), which runs
 * while the DI container is compiled. A violation therefore breaks the whole build, not
 * just the one request - and it stays invisible on a development machine, because Nette
 * only scans presenters found in the Composer classmap, which is generated exclusively by
 * an optimized (deployment) install.
 *
 * @implements Rule<ClassMethod>
 */
final class PresenterMethodVisibilityRule implements Rule
{
    private const PRESENTER_CLASS = 'Nette\\Application\\UI\\Presenter';

    /** action*, render* and handle* methods are entry points invoked by Nette itself */
    private const ENTRY_POINT_PATTERN = '#^(?!handleInvalidLink)(action.|render.|handle.)#';

    private const COMPONENT_FACTORY_PATTERN = '#^createComponent.#';

    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @param ClassMethod $node
     *
     * @return list<IdentifierRuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $scope->getClassReflection();

        if (null === $classReflection || false === $this->isPresenter($classReflection)) {
            return [];
        }

        $methodName = $node->name->toString();

        if (1 === \preg_match(self::ENTRY_POINT_PATTERN, $methodName) && (false === $node->isPublic() || $node->isStatic())) {
            return [
                RuleErrorBuilder::message(\sprintf(
                    'Method %s::%s() must be public non-static.',
                    $classReflection->getDisplayName(),
                    $methodName,
                ))
                    ->identifier('presenterMethod.mustBePublic')
                    ->tip('Nette rejects this while compiling the DI container. Rename the method unless it really is an action, render or signal entry point.')
                    ->build(),
            ];
        }

        if (1 === \preg_match(self::COMPONENT_FACTORY_PATTERN, $methodName) && ($node->isPrivate() || $node->isStatic())) {
            return [
                RuleErrorBuilder::message(\sprintf(
                    'Method %s::%s() must be non-private non-static.',
                    $classReflection->getDisplayName(),
                    $methodName,
                ))
                    ->identifier('presenterMethod.mustNotBePrivate')
                    ->tip('Nette rejects this while compiling the DI container. Rename the method unless it really is a component factory.')
                    ->build(),
            ];
        }

        return [];
    }

    private function isPresenter(ClassReflection $classReflection): bool
    {
        for ($class = $classReflection; null !== $class; $class = $class->getParentClass()) {
            if (self::PRESENTER_CLASS === $class->getName()) {
                return true;
            }
        }

        return false;
    }
}
