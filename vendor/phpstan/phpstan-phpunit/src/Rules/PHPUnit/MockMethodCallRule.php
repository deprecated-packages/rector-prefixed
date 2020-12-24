<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\PHPUnit;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use _PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\MockObject;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\MethodCall>
 */
class MockMethodCallRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        /** @var Node\Expr\MethodCall $node */
        $node = $node;
        if (!$node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier || $node->name->name !== 'method') {
            return [];
        }
        if (\count($node->args) < 1) {
            return [];
        }
        $argType = $scope->getType($node->args[0]->value);
        if (!$argType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            return [];
        }
        $method = $argType->getValue();
        $type = $scope->getType($node->var);
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType && \in_array(\_PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\MockObject::class, $type->getReferencedClasses(), \true) && !$type->hasMethod($method)->yes()) {
            $mockClass = \array_filter($type->getReferencedClasses(), function (string $class) : bool {
                return $class !== \_PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\MockObject::class;
            });
            return [\sprintf('Trying to mock an undefined method %s() on class %s.', $method, \implode('&', $mockClass))];
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType && $type->getClassName() === \_PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class && \count($type->getTypes()) > 0) {
            $mockClass = $type->getTypes()[0];
            if ($mockClass instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType && !$mockClass->hasMethod($method)->yes()) {
                return [\sprintf('Trying to mock an undefined method %s() on class %s.', $method, $mockClass->getClassName())];
            }
        }
        return [];
    }
}
