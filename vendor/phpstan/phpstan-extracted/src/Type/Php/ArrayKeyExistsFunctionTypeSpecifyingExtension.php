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
use PHPStan\Type\Accessory\HasOffsetType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\TypeCombinator;
class ArrayKeyExistsFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function setTypeSpecifier(\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'array_key_exists' && \count($node->args) >= 2 && !$context->null();
    }
    public function specifyTypes(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        $keyType = $scope->getType($node->args[0]->value);
        if ($context->truthy()) {
            $type = \PHPStan\Type\TypeCombinator::intersect(new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\Accessory\HasOffsetType($keyType));
        } else {
            $type = new \PHPStan\Type\Accessory\HasOffsetType($keyType);
        }
        return $this->typeSpecifier->create($node->args[1]->value, $type, $context);
    }
}
