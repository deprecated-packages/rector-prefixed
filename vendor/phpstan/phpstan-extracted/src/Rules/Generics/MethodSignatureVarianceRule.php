<?php

declare (strict_types=1);
namespace PHPStan\Rules\Generics;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassMethodNode;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class MethodSignatureVarianceRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Generics\VarianceCheck */
    private $varianceCheck;
    public function __construct(\PHPStan\Rules\Generics\VarianceCheck $varianceCheck)
    {
        $this->varianceCheck = $varianceCheck;
    }
    public function getNodeType() : string
    {
        return \PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \PHPStan\Reflection\MethodReflection) {
            return [];
        }
        return $this->varianceCheck->checkParametersAcceptor(\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants()), \sprintf('in parameter %%s of method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('in return type of method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('in method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), $method->getName() === '__construct' || $method->isStatic());
    }
}
