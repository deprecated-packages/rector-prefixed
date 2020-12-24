<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector;
use _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector\Source\NetteServiceDefinition;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\MethodCallToAnotherMethodCallWithArguments;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallToAnotherMethodCallWithArgumentsRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector::class => [\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector::METHOD_CALL_RENAMES_WITH_ADDED_ARGUMENTS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\MethodCallToAnotherMethodCallWithArguments(\_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector\Source\NetteServiceDefinition::class, 'setInject', 'addTag', ['inject'])]]];
    }
}
