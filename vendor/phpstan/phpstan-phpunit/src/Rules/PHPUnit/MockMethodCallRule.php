<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\PHPUnit;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use _PhpScopere8e811afab72\PHPUnit\Framework\MockObject\MockObject;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\MethodCall>
 */
class MockMethodCallRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        /** @var Node\Expr\MethodCall $node */
        $node = $node;
        if (!$node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier || $node->name->name !== 'method') {
            return [];
        }
        if (\count($node->args) < 1) {
            return [];
        }
        $argType = $scope->getType($node->args[0]->value);
        if (!$argType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            return [];
        }
        $method = $argType->getValue();
        $type = $scope->getType($node->var);
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType && \in_array(\_PhpScopere8e811afab72\PHPUnit\Framework\MockObject\MockObject::class, $type->getReferencedClasses(), \true) && !$type->hasMethod($method)->yes()) {
            $mockClass = \array_filter($type->getReferencedClasses(), function (string $class) : bool {
                return $class !== \_PhpScopere8e811afab72\PHPUnit\Framework\MockObject\MockObject::class;
            });
            return [\sprintf('Trying to mock an undefined method %s() on class %s.', $method, \implode('&', $mockClass))];
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType && $type->getClassName() === \_PhpScopere8e811afab72\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class && \count($type->getTypes()) > 0) {
            $mockClass = $type->getTypes()[0];
            if ($mockClass instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType && !$mockClass->hasMethod($method)->yes()) {
                return [\sprintf('Trying to mock an undefined method %s() on class %s.', $method, $mockClass->getClassName())];
            }
        }
        return [];
    }
}
