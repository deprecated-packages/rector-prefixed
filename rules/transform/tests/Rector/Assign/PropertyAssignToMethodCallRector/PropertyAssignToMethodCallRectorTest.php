<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector;
use _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector\Source\ChoiceControl;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyAssignToMethodCall;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyAssignToMethodCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector::class => [\_PhpScopere8e811afab72\Rector\Transform\Rector\Assign\PropertyAssignToMethodCallRector::PROPERTY_ASSIGNS_TO_METHODS_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyAssignToMethodCall(\_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector\Source\ChoiceControl::class, 'checkAllowedValues', 'checkDefaultValue')]]];
    }
}
