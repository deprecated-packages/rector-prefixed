<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NeverType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeTraverser;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
class IsSubclassOfFunctionTypeSpecifyingExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_subclass_of' && \count($node->args) >= 2 && !$context->null();
    }
    public function specifyTypes(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes
    {
        $objectType = $scope->getType($node->args[0]->value);
        $classType = $scope->getType($node->args[1]->value);
        $allowStringType = isset($node->args[2]) ? $scope->getType($node->args[2]->value) : new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\true);
        $allowString = !$allowStringType->equals(new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false));
        if (!$classType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            if ($context->truthy()) {
                if ($allowString) {
                    $type = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType());
                } else {
                    $type = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType();
                }
                return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
            }
            return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes();
        }
        $type = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeTraverser::map($objectType, static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, callable $traverse) use($classType, $allowString) : Type {
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
                return $traverse($type);
            }
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($allowString) {
                if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType) {
                    return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType(new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($classType->getValue()));
                }
            }
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($classType->getValue());
            }
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($classType->getValue());
                if ($allowString) {
                    return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType($objectType), $objectType);
                }
                return $objectType;
            }
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType();
        });
        return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
    }
    public function setTypeSpecifier(\_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
