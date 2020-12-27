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
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
class DefineConstantTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function setTypeSpecifier(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'define' && $context->null() && \count($node->args) >= 2;
    }
    public function specifyTypes(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes
    {
        $constantName = $scope->getType($node->args[0]->value);
        if (!$constantName instanceof \PHPStan\Type\Constant\ConstantStringType || $constantName->getValue() === '') {
            return new \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        return $this->typeSpecifier->create(new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name\FullyQualified($constantName->getValue())), $scope->getType($node->args[1]->value), \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext::createTruthy());
    }
}
