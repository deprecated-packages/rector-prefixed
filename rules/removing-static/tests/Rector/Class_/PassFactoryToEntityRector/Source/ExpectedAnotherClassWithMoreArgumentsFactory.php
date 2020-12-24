<?php

namespace _PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture;

final class AnotherClassWithMoreArgumentsFactory
{
    /**
     * @var \Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService
     */
    private $turnMeToService;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService $turnMeToService)
    {
        $this->turnMeToService = $turnMeToService;
    }
    public function create($number) : \_PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture\AnotherClassWithMoreArguments
    {
        return new \_PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture\AnotherClassWithMoreArguments($number, $this->turnMeToService);
    }
}
