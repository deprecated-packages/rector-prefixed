<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\PHPUnit;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use _PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\MockObject;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\MethodCall>
 */
class MockMethodCallRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        /** @var Node\Expr\MethodCall $node */
        $node = $node;
        if (!$node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier || $node->name->name !== 'method') {
            return [];
        }
        if (\count($node->args) < 1) {
            return [];
        }
        $argType = $scope->getType($node->args[0]->value);
        if (!$argType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            return [];
        }
        $method = $argType->getValue();
        $type = $scope->getType($node->var);
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType && \in_array(\_PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\MockObject::class, $type->getReferencedClasses(), \true) && !$type->hasMethod($method)->yes()) {
            $mockClass = \array_filter($type->getReferencedClasses(), function (string $class) : bool {
                return $class !== \_PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\MockObject::class;
            });
            return [\sprintf('Trying to mock an undefined method %s() on class %s.', $method, \implode('&', $mockClass))];
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType && $type->getClassName() === \_PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class && \count($type->getTypes()) > 0) {
            $mockClass = $type->getTypes()[0];
            if ($mockClass instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType && !$mockClass->hasMethod($method)->yes()) {
                return [\sprintf('Trying to mock an undefined method %s() on class %s.', $method, $mockClass->getClassName())];
            }
        }
        return [];
    }
}
