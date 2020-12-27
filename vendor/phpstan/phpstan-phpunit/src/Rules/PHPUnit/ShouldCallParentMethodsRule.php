<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\PHPUnit;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InClassMethodNode;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPUnit\Framework\TestCase;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class ShouldCallParentMethodsRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $methodName = $node->getOriginalNode()->name->name;
        if (!\in_array(\strtolower($methodName), ['setup', 'teardown'], \true)) {
            return [];
        }
        if ($scope->getClassReflection() === null) {
            return [];
        }
        if (!$scope->getClassReflection()->isSubclassOf(\RectorPrefix20201227\PHPUnit\Framework\TestCase::class)) {
            return [];
        }
        $parentClass = $scope->getClassReflection()->getParentClass();
        if ($parentClass === \false) {
            return [];
        }
        if (!$parentClass->hasNativeMethod($methodName)) {
            return [];
        }
        $parentMethod = $parentClass->getNativeMethod($methodName);
        if ($parentMethod->getDeclaringClass()->getName() === \RectorPrefix20201227\PHPUnit\Framework\TestCase::class) {
            return [];
        }
        $hasParentCall = $this->hasParentClassCall($node->getOriginalNode()->getStmts(), \strtolower($methodName));
        if (!$hasParentCall) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Missing call to parent::%s() method.', $methodName))->build()];
        }
        return [];
    }
    /**
     * @param Node\Stmt[]|null $stmts
     * @param string           $methodName
     *
     * @return bool
     */
    private function hasParentClassCall(?array $stmts, string $methodName) : bool
    {
        if ($stmts === null) {
            return \false;
        }
        foreach ($stmts as $stmt) {
            if (!$stmt instanceof \PhpParser\Node\Stmt\Expression) {
                continue;
            }
            if (!$stmt->expr instanceof \PhpParser\Node\Expr\StaticCall) {
                continue;
            }
            if (!$stmt->expr->class instanceof \PhpParser\Node\Name) {
                continue;
            }
            $class = (string) $stmt->expr->class;
            if (\strtolower($class) !== 'parent') {
                continue;
            }
            if (!$stmt->expr->name instanceof \PhpParser\Node\Identifier) {
                continue;
            }
            if (\strtolower($stmt->expr->name->name) === $methodName) {
                return \true;
            }
        }
        return \false;
    }
}
