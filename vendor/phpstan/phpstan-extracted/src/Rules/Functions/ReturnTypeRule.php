<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use PHPStan\Rules\FunctionReturnTypeCheck;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Return_>
 */
class ReturnTypeRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionReturnTypeCheck */
    private $returnTypeCheck;
    /** @var FunctionReflector */
    private $functionReflector;
    public function __construct(\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector)
    {
        $this->returnTypeCheck = $returnTypeCheck;
        $this->functionReflector = $functionReflector;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Return_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($scope->getFunction() === null) {
            return [];
        }
        if ($scope->isInAnonymousFunction()) {
            return [];
        }
        $function = $scope->getFunction();
        if (!$function instanceof \PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection || $function instanceof \PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
            return [];
        }
        $reflection = null;
        if (\function_exists($function->getName())) {
            $reflection = new \ReflectionFunction($function->getName());
        } else {
            try {
                $reflection = $this->functionReflector->reflect($function->getName());
            } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            }
        }
        return $this->returnTypeCheck->checkReturnType($scope, \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants())->getReturnType(), $node->expr, \sprintf('Function %s() should return %%s but empty return statement found.', $function->getName()), \sprintf('Function %s() with return type void returns %%s but should not return anything.', $function->getName()), \sprintf('Function %s() should return %%s but returns %%s.', $function->getName()), \sprintf('Function %s() should never return but return statement found.', $function->getName()), $reflection !== null && $reflection->isGenerator());
    }
}
