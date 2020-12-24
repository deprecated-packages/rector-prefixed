<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source;

class FirstService
{
    /**
     * @var AnotherService
     */
    private $anotherService;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source\AnotherService $anotherService)
    {
        $this->anotherService = $anotherService;
    }
    public function getAnotherService() : \_PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source\AnotherService
    {
        return $this->anotherService;
    }
}
