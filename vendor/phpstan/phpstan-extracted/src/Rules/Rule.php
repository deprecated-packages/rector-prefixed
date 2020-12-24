<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
/**
 * @phpstan-template TNodeType of \PhpParser\Node
 */
interface Rule
{
    /**
     * @phpstan-return class-string<TNodeType>
     * @return string
     */
    public function getNodeType() : string;
    /**
     * @phpstan-param TNodeType $node
     * @param \PhpParser\Node $node
     * @param \PHPStan\Analyser\Scope $scope
     * @return (string|RuleError)[] errors
     */
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array;
}
