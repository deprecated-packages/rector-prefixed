<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Comparator\Parameter;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\NodeCollector\Reflection\MethodReflectionProvider;
final class ParameterTypeComparator
{
    /**
     * @var MethodReflectionProvider
     */
    private $methodReflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeCollector\Reflection\MethodReflectionProvider $methodReflectionProvider)
    {
        $this->methodReflectionProvider = $methodReflectionProvider;
    }
    public function compareCurrentClassMethodAndParentStaticCall(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall $staticCall) : bool
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
