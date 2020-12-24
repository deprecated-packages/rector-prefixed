<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
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
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array;
}
