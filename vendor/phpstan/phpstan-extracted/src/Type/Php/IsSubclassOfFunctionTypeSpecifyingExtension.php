<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
class IsSubclassOfFunctionTypeSpecifyingExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_subclass_of' && \count($node->args) >= 2 && !$context->null();
    }
    public function specifyTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes
    {
        $objectType = $scope->getType($node->args[0]->value);
        $classType = $scope->getType($node->args[1]->value);
        $allowStringType = isset($node->args[2]) ? $scope->getType($node->args[2]->value) : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\true);
        $allowString = !$allowStringType->equals(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false));
        if (!$classType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
            if ($context->truthy()) {
                if ($allowString) {
                    $type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType());
                } else {
                    $type = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType();
                }
                return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
            }
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes();
        }
        $type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser::map($objectType, static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, callable $traverse) use($classType, $allowString) : Type {
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
                return $traverse($type);
            }
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($allowString) {
                if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType) {
                    return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($classType->getValue()));
                }
            }
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType || $type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($classType->getValue());
            }
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
                $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($classType->getValue());
                if ($allowString) {
                    return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType($objectType), $objectType);
                }
                return $objectType;
            }
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType();
        });
        return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
    }
    public function setTypeSpecifier(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
