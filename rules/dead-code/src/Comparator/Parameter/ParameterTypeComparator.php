<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\Comparator\Parameter;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\Reflection\MethodReflectionProvider;
final class ParameterTypeComparator
{
    /**
     * @var MethodReflectionProvider
     */
    private $methodReflectionProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeCollector\Reflection\MethodReflectionProvider $methodReflectionProvider)
    {
        $this->methodReflectionProvider = $methodReflectionProvider;
    }
    public function compareCurrentClassMethodAndParentStaticCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall) : bool
    {
        $currentParameterTypes = $this->methodReflectionProvider->provideParameterTypesByClassMethod($classMethod);
        $parentParameterTypes = $this->methodReflectionProvider->provideParameterTypesByStaticCall($staticCall);
        foreach ($currentParameterTypes as $key => $currentParameterType) {
            if (!isset($parentParameterTypes[$key])) {
                continue;
            }
            $parentParameterType = $parentParameterTypes[$key];
            if (!$currentParameterType->equals($parentParameterType)) {
                return \false;
            }
        }
        return \true;
    }
}
