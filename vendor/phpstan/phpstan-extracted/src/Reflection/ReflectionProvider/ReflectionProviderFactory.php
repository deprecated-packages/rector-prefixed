<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;

use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
class ReflectionProviderFactory
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $runtimeReflectionProvider;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $staticReflectionProvider;
    /** @var bool */
    private $disableRuntimeReflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $runtimeReflectionProvider, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $staticReflectionProvider, bool $disableRuntimeReflectionProvider)
    {
        $this->runtimeReflectionProvider = $runtimeReflectionProvider;
        $this->staticReflectionProvider = $staticReflectionProvider;
        $this->disableRuntimeReflectionProvider = $disableRuntimeReflectionProvider;
    }
    public function create() : \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider
    {
        $providers = [];
        if (!$this->disableRuntimeReflectionProvider) {
            $providers[] = $this->runtimeReflectionProvider;
        }
        $providers[] = $this->staticReflectionProvider;
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider\MemoizingReflectionProvider(\count($providers) === 1 ? $providers[0] : new \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider\ChainReflectionProvider($providers));
    }
}
