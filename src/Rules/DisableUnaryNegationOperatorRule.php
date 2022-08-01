<?php declare(strict_types = 1);

namespace Inspire\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\BooleanNot;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

final class DisableUnaryNegationOperatorRule implements Rule
{
    public function getNodeType(): string
    {
        return BooleanNot::class;
    }

    /**
     * @param BooleanNot $node
     *
     * @return string[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return [
            'Using unary negation operator "!" is not allowed.',
        ];
    }
}
