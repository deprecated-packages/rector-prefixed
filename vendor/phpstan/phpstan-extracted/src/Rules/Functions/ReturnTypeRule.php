<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Functions;

use PhpParser\Node;
use PhpParser\Node\Stmt\Return_;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use RectorPrefix20201227\PHPStan\Rules\FunctionReturnTypeCheck;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\FunctionReflector;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Return_>
 */
class ReturnTypeRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionReturnTypeCheck */
    private $returnTypeCheck;
    /** @var FunctionReflector */
    private $functionReflector;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector)
    {
        $this->returnTypeCheck = $returnTypeCheck;
        $this->functionReflector = $functionReflector;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Return_::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if ($scope->getFunction() === null) {
            return [];
        }
        if ($scope->isInAnonymousFunction()) {
            return [];
        }
        $function = $scope->getFunction();
        if (!$function instanceof \RectorPrefix20201227\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection || $function instanceof \RectorPrefix20201227\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
            return [];
        }
        $reflection = null;
        if (\function_exists($function->getName())) {
            $reflection = new \ReflectionFunction($function->getName());
        } else {
            try {
                $reflection = $this->functionReflector->reflect($function->getName());
            } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            }
        }
        return $this->returnTypeCheck->checkReturnType($scope, \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants())->getReturnType(), $node->expr, \sprintf('Function %s() should return %%s but empty return statement found.', $function->getName()), \sprintf('Function %s() with return type void returns %%s but should not return anything.', $function->getName()), \sprintf('Function %s() should return %%s but returns %%s.', $function->getName()), \sprintf('Function %s() should never return but return statement found.', $function->getName()), $reflection !== null && $reflection->isGenerator());
    }
}
