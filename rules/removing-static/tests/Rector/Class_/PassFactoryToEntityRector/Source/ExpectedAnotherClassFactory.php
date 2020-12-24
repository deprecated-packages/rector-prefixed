<?php

namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture;

final class AnotherClassFactory
{
    /**
     * @var \Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService
     */
    private $turnMeToService;
    public function __construct(\_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Source\TurnMeToService $turnMeToService)
    {
        $this->turnMeToService = $turnMeToService;
    }
    public function create() : \_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture\AnotherClass
    {
        return new \_PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PassFactoryToEntityRector\Fixture\AnotherClass($this->turnMeToService);
    }
}
