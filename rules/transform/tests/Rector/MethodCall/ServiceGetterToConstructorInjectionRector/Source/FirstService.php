<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source;

class FirstService
{
    /**
     * @var AnotherService
     */
    private $anotherService;
    public function __construct(\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source\AnotherService $anotherService)
    {
        $this->anotherService = $anotherService;
    }
    public function getAnotherService() : \Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source\AnotherService
    {
        return $this->anotherService;
    }
}
