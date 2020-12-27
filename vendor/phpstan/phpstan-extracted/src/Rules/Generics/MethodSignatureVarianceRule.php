<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Generics;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InClassMethodNode;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class MethodSignatureVarianceRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Generics\VarianceCheck */
    private $varianceCheck;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\Generics\VarianceCheck $varianceCheck)
    {
        $this->varianceCheck = $varianceCheck;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \RectorPrefix20201227\PHPStan\Reflection\MethodReflection) {
            return [];
        }
        return $this->varianceCheck->checkParametersAcceptor(\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants()), \sprintf('in parameter %%s of method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('in return type of method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('in method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), $method->getName() === '__construct' || $method->isStatic());
    }
}
