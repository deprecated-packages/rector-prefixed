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
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\MixedType;
class CountFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return !$context->null() && \count($node->args) >= 1 && $functionReflection->getName() === 'count';
    }
    public function specifyTypes(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        if (!(new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()))->isSuperTypeOf($scope->getType($node->args[0]->value))->yes()) {
            return new \PHPStan\Analyser\SpecifiedTypes([], []);
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \PHPStan\Type\Accessory\NonEmptyArrayType(), $context);
    }
    public function setTypeSpecifier(\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
