<?php

namespace _PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture;

final class AnotherClassWithMoreArgumentsFactory
{
    /**
     * @var \Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService
     */
    private $turnMeToService;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService $turnMeToService)
    {
        $this->turnMeToService = $turnMeToService;
    }
    public function create($number) : \_PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture\AnotherClassWithMoreArguments
    {
        return new \_PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture\AnotherClassWithMoreArguments($number, $this->turnMeToService);
    }
}
