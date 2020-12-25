<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeTraverser;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
class IsSubclassOfFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_subclass_of' && \count($node->args) >= 2 && !$context->null();
    }
    public function specifyTypes(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        $objectType = $scope->getType($node->args[0]->value);
        $classType = $scope->getType($node->args[1]->value);
        $allowStringType = isset($node->args[2]) ? $scope->getType($node->args[2]->value) : new \PHPStan\Type\Constant\ConstantBooleanType(\true);
        $allowString = !$allowStringType->equals(new \PHPStan\Type\Constant\ConstantBooleanType(\false));
        if (!$classType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            if ($context->truthy()) {
                if ($allowString) {
                    $type = \PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\ClassStringType());
                } else {
                    $type = new \PHPStan\Type\ObjectWithoutClassType();
                }
                return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
            }
            return new \PHPStan\Analyser\SpecifiedTypes();
        }
        $type = \PHPStan\Type\TypeTraverser::map($objectType, static function (\PHPStan\Type\Type $type, callable $traverse) use($classType, $allowString) : Type {
            if ($type instanceof \PHPStan\Type\UnionType) {
                return $traverse($type);
            }
            if ($type instanceof \PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($allowString) {
                if ($type instanceof \PHPStan\Type\StringType) {
                    return new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType($classType->getValue()));
                }
            }
            if ($type instanceof \PHPStan\Type\ObjectWithoutClassType || $type instanceof \PHPStan\Type\TypeWithClassName) {
                return new \PHPStan\Type\ObjectType($classType->getValue());
            }
            if ($type instanceof \PHPStan\Type\MixedType) {
                $objectType = new \PHPStan\Type\ObjectType($classType->getValue());
                if ($allowString) {
                    return \PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Generic\GenericClassStringType($objectType), $objectType);
                }
                return $objectType;
            }
            return new \PHPStan\Type\NeverType();
        });
        return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
    }
    public function setTypeSpecifier(\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
