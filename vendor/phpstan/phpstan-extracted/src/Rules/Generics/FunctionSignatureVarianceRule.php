<?php

declare (strict_types=1);
namespace PHPStan\Rules\Generics;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InFunctionNode;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<InFunctionNode>
 */
class FunctionSignatureVarianceRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Generics\VarianceCheck */
    private $varianceCheck;
    public function __construct(\PHPStan\Rules\Generics\VarianceCheck $varianceCheck)
    {
        $this->varianceCheck = $varianceCheck;
    }
    public function getNodeType() : string
    {
        return \PHPStan\Node\InFunctionNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $functionReflection = $scope->getFunction();
        if ($functionReflection === null) {
            return [];
        }
        $functionName = $functionReflection->getName();
        return $this->varianceCheck->checkParametersAcceptor(\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants()), \sprintf('in parameter %%s of function %s()', $functionName), \sprintf('in return type of function %s()', $functionName), \sprintf('in function %s()', $functionName), \false);
    }
}
