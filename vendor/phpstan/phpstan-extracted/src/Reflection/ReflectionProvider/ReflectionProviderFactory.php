<?php

declare (strict_types=1);
namespace PHPStan\Reflection\ReflectionProvider;

use PHPStan\Reflection\ReflectionProvider;
class ReflectionProviderFactory
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $runtimeReflectionProvider;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $staticReflectionProvider;
    /** @var bool */
    private $disableRuntimeReflectionProvider;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $runtimeReflectionProvider, \PHPStan\Reflection\ReflectionProvider $staticReflectionProvider, bool $disableRuntimeReflectionProvider)
    {
        $this->runtimeReflectionProvider = $runtimeReflectionProvider;
        $this->staticReflectionProvider = $staticReflectionProvider;
        $this->disableRuntimeReflectionProvider = $disableRuntimeReflectionProvider;
    }
    public function create() : \PHPStan\Reflection\ReflectionProvider
    {
        $providers = [];
        if (!$this->disableRuntimeReflectionProvider) {
            $providers[] = $this->runtimeReflectionProvider;
        }
        $providers[] = $this->staticReflectionProvider;
        return new \PHPStan\Reflection\ReflectionProvider\MemoizingReflectionProvider(\count($providers) === 1 ? $providers[0] : new \PHPStan\Reflection\ReflectionProvider\ChainReflectionProvider($providers));
    }
}
