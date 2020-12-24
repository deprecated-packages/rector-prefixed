<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source;

class FirstService
{
    /**
     * @var AnotherService
     */
    private $anotherService;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source\AnotherService $anotherService)
    {
        $this->anotherService = $anotherService;
    }
    public function getAnotherService() : \_PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\MethodCall\ServiceGetterToConstructorInjectionRector\Source\AnotherService
    {
        return $this->anotherService;
    }
}
