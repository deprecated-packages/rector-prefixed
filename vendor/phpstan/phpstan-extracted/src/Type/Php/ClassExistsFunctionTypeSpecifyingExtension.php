<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
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
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
class ClassExistsFunctionTypeSpecifyingExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \in_array($functionReflection->getName(), ['class_exists', 'interface_exists', 'trait_exists'], \true) && isset($node->args[0]) && $context->truthy();
    }
    public function specifyTypes(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes
    {
        $argType = $scope->getType($node->args[0]->value);
        $classStringType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType();
        if (\_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect($argType, $classStringType) instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType) {
            if ($argType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
                return $this->typeSpecifier->create(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('class_exists'), [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_(\ltrim($argType->getValue(), '\\')))]), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\true), $context);
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes();
        }
        return $this->typeSpecifier->create($node->args[0]->value, $classStringType, $context);
    }
    public function setTypeSpecifier(\_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
