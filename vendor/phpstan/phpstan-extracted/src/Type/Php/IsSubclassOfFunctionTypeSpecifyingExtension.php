<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
class IsSubclassOfFunctionTypeSpecifyingExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_subclass_of' && \count($node->args) >= 2 && !$context->null();
    }
    public function specifyTypes(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes
    {
        $objectType = $scope->getType($node->args[0]->value);
        $classType = $scope->getType($node->args[1]->value);
        $allowStringType = isset($node->args[2]) ? $scope->getType($node->args[2]->value) : new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\true);
        $allowString = !$allowStringType->equals(new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false));
        if (!$classType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            if ($context->truthy()) {
                if ($allowString) {
                    $type = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType());
                } else {
                    $type = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType();
                }
                return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes();
        }
        $type = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser::map($objectType, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, callable $traverse) use($classType, $allowString) : Type {
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
                return $traverse($type);
            }
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($allowString) {
                if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StringType) {
                    return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType(new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($classType->getValue()));
                }
            }
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType || $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($classType->getValue());
            }
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($classType->getValue());
                if ($allowString) {
                    return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType($objectType), $objectType);
                }
                return $objectType;
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType();
        });
        return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
    }
    public function setTypeSpecifier(\_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
