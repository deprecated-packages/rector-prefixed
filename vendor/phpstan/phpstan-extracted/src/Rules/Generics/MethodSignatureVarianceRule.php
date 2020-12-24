<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Generics;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Node\InClassMethodNode;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class MethodSignatureVarianceRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Generics\VarianceCheck */
    private $varianceCheck;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\Generics\VarianceCheck $varianceCheck)
    {
        $this->varianceCheck = $varianceCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection) {
            return [];
        }
        return $this->varianceCheck->checkParametersAcceptor(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants()), \sprintf('in parameter %%s of method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('in return type of method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('in method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), $method->getName() === '__construct' || $method->isStatic());
    }
}
