<?php declare(strict_types = 1);

namespace Inspire\PHPStan\Type\Nette;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\ArrayType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;

/**
 * `getValues('array')` and `getUntrustedValues('array')` return an array. The return type of nette/forms 3.3 tests
 * a class name before the string 'array', and PHPStan cannot rule out that 'array' names a class, so it answers
 * `array|array<mixed>` with an object of the class "array" in it. Every other call keeps the type of the PHPDoc.
 * Delete once nette/forms tests 'array' first.
 */
final class FormValuesArrayReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return 'Nette\Forms\Container';
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return \in_array($methodReflection->getName(), ['getValues', 'getUntrustedValues'], true);
    }

    public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): ?Type
    {
        $args = $methodCall->getArgs();

        if ([] === $args) {
            return null;
        }

        $returnType = $scope->getType($args[0]->value)->getConstantStrings();

        if (1 !== \count($returnType) || 'array' !== $returnType[0]->getValue()) {
            return null;
        }

        return new ArrayType(new MixedType(), new MixedType());
    }
}
