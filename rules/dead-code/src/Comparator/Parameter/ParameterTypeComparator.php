<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Comparator\Parameter;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\Reflection\MethodReflectionProvider;
final class ParameterTypeComparator
{
    /**
     * @var MethodReflectionProvider
     */
    private $methodReflectionProvider;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeCollector\Reflection\MethodReflectionProvider $methodReflectionProvider)
    {
        $this->methodReflectionProvider = $methodReflectionProvider;
    }
    public function compareCurrentClassMethodAndParentStaticCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : bool
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
