<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Functions;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use _PhpScoperb75b35f52b74\PHPStan\Rules\FunctionReturnTypeCheck;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Return_>
 */
class ReturnTypeRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionReturnTypeCheck */
    private $returnTypeCheck;
    /** @var FunctionReflector */
    private $functionReflector;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector)
    {
        $this->returnTypeCheck = $returnTypeCheck;
        $this->functionReflector = $functionReflector;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if ($scope->getFunction() === null) {
            return [];
        }
        if ($scope->isInAnonymousFunction()) {
            return [];
        }
        $function = $scope->getFunction();
        if (!$function instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection || $function instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
            return [];
        }
        $reflection = null;
        if (\function_exists($function->getName())) {
            $reflection = new \ReflectionFunction($function->getName());
        } else {
            try {
                $reflection = $this->functionReflector->reflect($function->getName());
            } catch (\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            }
        }
        return $this->returnTypeCheck->checkReturnType($scope, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants())->getReturnType(), $node->expr, \sprintf('Function %s() should return %%s but empty return statement found.', $function->getName()), \sprintf('Function %s() with return type void returns %%s but should not return anything.', $function->getName()), \sprintf('Function %s() should return %%s but returns %%s.', $function->getName()), \sprintf('Function %s() should never return but return statement found.', $function->getName()), $reflection !== null && $reflection->isGenerator());
    }
}
