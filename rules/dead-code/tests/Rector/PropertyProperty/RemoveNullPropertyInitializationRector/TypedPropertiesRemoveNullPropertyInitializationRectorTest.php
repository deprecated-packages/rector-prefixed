<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Tests\Rector\PropertyProperty\RemoveNullPropertyInitializationRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class TypedPropertiesRemoveNullPropertyInitializationRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @requires PHP 7.4
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureTypedProperties');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES;
    }
}
