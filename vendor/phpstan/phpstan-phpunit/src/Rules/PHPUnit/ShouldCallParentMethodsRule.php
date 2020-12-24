<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\PHPUnit;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Node\InClassMethodNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPUnit\Framework\TestCase;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class ShouldCallParentMethodsRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        $methodName = $node->getOriginalNode()->name->name;
        if (!\in_array(\strtolower($methodName), ['setup', 'teardown'], \true)) {
            return [];
        }
        if ($scope->getClassReflection() === null) {
            return [];
        }
        if (!$scope->getClassReflection()->isSubclassOf(\_PhpScoper2a4e7ab1ecbc\PHPUnit\Framework\TestCase::class)) {
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
        if ($parentMethod->getDeclaringClass()->getName() === \_PhpScoper2a4e7ab1ecbc\PHPUnit\Framework\TestCase::class) {
            return [];
        }
        $hasParentCall = $this->hasParentClassCall($node->getOriginalNode()->getStmts(), \strtolower($methodName));
        if (!$hasParentCall) {
            return [\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Missing call to parent::%s() method.', $methodName))->build()];
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
            if (!$stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            if (!$stmt->expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall) {
                continue;
            }
            if (!$stmt->expr->class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name) {
                continue;
            }
            $class = (string) $stmt->expr->class;
            if (\strtolower($class) !== 'parent') {
                continue;
            }
            if (!$stmt->expr->name instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier) {
                continue;
            }
            if (\strtolower($stmt->expr->name->name) === $methodName) {
                return \true;
            }
        }
        return \false;
    }
}
