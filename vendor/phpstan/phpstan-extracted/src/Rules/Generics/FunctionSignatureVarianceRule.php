<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Generics;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InFunctionNode;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<InFunctionNode>
 */
class FunctionSignatureVarianceRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Generics\VarianceCheck */
    private $varianceCheck;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\Generics\VarianceCheck $varianceCheck)
    {
        $this->varianceCheck = $varianceCheck;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\InFunctionNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $functionReflection = $scope->getFunction();
        if ($functionReflection === null) {
            return [];
        }
        $functionName = $functionReflection->getName();
        return $this->varianceCheck->checkParametersAcceptor(\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants()), \sprintf('in parameter %%s of function %s()', $functionName), \sprintf('in return type of function %s()', $functionName), \sprintf('in function %s()', $functionName), \false);
    }
}
