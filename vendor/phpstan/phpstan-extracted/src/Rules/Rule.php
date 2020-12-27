<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
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
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array;
}
