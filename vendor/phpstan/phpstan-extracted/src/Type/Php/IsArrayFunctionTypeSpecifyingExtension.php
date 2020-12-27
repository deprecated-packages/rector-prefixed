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
use PHPStan\Type\ArrayType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\MixedType;
class IsArrayFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_array' && isset($node->args[0]) && !$context->null();
    }
    public function specifyTypes(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes
    {
        if ($context->null()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), $context);
    }
    public function setTypeSpecifier(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
