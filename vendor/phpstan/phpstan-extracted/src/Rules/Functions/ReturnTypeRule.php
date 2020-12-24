<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Functions;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\FunctionReturnTypeCheck;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Return_>
 */
class ReturnTypeRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionReturnTypeCheck */
    private $returnTypeCheck;
    /** @var FunctionReflector */
    private $functionReflector;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector)
    {
        $this->returnTypeCheck = $returnTypeCheck;
        $this->functionReflector = $functionReflector;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        if ($scope->getFunction() === null) {
            return [];
        }
        if ($scope->isInAnonymousFunction()) {
            return [];
        }
        $function = $scope->getFunction();
        if (!$function instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection || $function instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
            return [];
        }
        $reflection = null;
        if (\function_exists($function->getName())) {
            $reflection = new \ReflectionFunction($function->getName());
        } else {
            try {
                $reflection = $this->functionReflector->reflect($function->getName());
            } catch (\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            }
        }
        return $this->returnTypeCheck->checkReturnType($scope, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants())->getReturnType(), $node->expr, \sprintf('Function %s() should return %%s but empty return statement found.', $function->getName()), \sprintf('Function %s() with return type void returns %%s but should not return anything.', $function->getName()), \sprintf('Function %s() should return %%s but returns %%s.', $function->getName()), \sprintf('Function %s() should never return but return statement found.', $function->getName()), $reflection !== null && $reflection->isGenerator());
    }
}
