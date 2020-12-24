<?php

namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture;

final class AnotherClassWithMoreArgumentsFactory
{
    /**
     * @var \Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService
     */
    private $turnMeToService;
    public function __construct(\_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService $turnMeToService)
    {
        $this->turnMeToService = $turnMeToService;
    }
    public function create($number) : \_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture\AnotherClassWithMoreArguments
    {
        return new \_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture\AnotherClassWithMoreArguments($number, $this->turnMeToService);
    }
}
