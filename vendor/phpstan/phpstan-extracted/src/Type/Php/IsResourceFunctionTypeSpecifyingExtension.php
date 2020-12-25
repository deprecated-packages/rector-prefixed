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
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\ResourceType;
class IsResourceFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_resource' && isset($node->args[0]) && !$context->null();
    }
    public function specifyTypes(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        if ($context->null()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \PHPStan\Type\ResourceType(), $context);
    }
    public function setTypeSpecifier(\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
