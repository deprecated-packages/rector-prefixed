<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
class ReflectionProviderFactory
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $runtimeReflectionProvider;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $staticReflectionProvider;
    /** @var bool */
    private $disableRuntimeReflectionProvider;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $runtimeReflectionProvider, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $staticReflectionProvider, bool $disableRuntimeReflectionProvider)
    {
        $this->runtimeReflectionProvider = $runtimeReflectionProvider;
        $this->staticReflectionProvider = $staticReflectionProvider;
        $this->disableRuntimeReflectionProvider = $disableRuntimeReflectionProvider;
    }
    public function create() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider
    {
        $providers = [];
        if (!$this->disableRuntimeReflectionProvider) {
            $providers[] = $this->runtimeReflectionProvider;
        }
        $providers[] = $this->staticReflectionProvider;
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\MemoizingReflectionProvider(\count($providers) === 1 ? $providers[0] : new \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider\ChainReflectionProvider($providers));
    }
}
