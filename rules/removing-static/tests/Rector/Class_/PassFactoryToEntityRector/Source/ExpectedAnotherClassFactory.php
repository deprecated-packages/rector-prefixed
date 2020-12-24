<?php

namespace _PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture;

final class AnotherClassFactory
{
    /**
     * @var \Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService
     */
    private $turnMeToService;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService $turnMeToService)
    {
        $this->turnMeToService = $turnMeToService;
    }
    public function create() : \_PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture\AnotherClass
    {
        return new \_PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture\AnotherClass($this->turnMeToService);
    }
}
