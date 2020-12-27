<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
class AssertFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'assert' && isset($node->args[0]);
    }
    public function specifyTypes(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes
    {
        return $this->typeSpecifier->specifyTypesInCondition($scope, $node->args[0]->value, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext::createTruthy());
    }
    public function setTypeSpecifier(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
