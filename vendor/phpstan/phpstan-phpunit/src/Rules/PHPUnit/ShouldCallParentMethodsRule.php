<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\PHPUnit;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Node\InClassMethodNode;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class ShouldCallParentMethodsRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $methodName = $node->getOriginalNode()->name->name;
        if (!\in_array(\strtolower($methodName), ['setup', 'teardown'], \true)) {
            return [];
        }
        if ($scope->getClassReflection() === null) {
            return [];
        }
        if (!$scope->getClassReflection()->isSubclassOf(\_PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase::class)) {
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
        if ($parentMethod->getDeclaringClass()->getName() === \_PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase::class) {
            return [];
        }
        $hasParentCall = $this->hasParentClassCall($node->getOriginalNode()->getStmts(), \strtolower($methodName));
        if (!$hasParentCall) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Missing call to parent::%s() method.', $methodName))->build()];
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
            if (!$stmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            if (!$stmt->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
                continue;
            }
            if (!$stmt->expr->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
                continue;
            }
            $class = (string) $stmt->expr->class;
            if (\strtolower($class) !== 'parent') {
                continue;
            }
            if (!$stmt->expr->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
                continue;
            }
            if (\strtolower($stmt->expr->name->name) === $methodName) {
                return \true;
            }
        }
        return \false;
    }
}
