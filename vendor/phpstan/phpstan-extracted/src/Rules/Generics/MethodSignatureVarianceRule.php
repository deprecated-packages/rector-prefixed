<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Node\InClassMethodNode;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Rule;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class MethodSignatureVarianceRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Generics\VarianceCheck */
    private $varianceCheck;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\VarianceCheck $varianceCheck)
    {
        $this->varianceCheck = $varianceCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection) {
            return [];
        }
        return $this->varianceCheck->checkParametersAcceptor(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants()), \sprintf('in parameter %%s of method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('in return type of method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('in method %s::%s()', $method->getDeclaringClass()->getDisplayName(), $method->getName()), $method->getName() === '__construct' || $method->isStatic());
    }
}
