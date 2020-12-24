<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\Transform\Rector\New_\NewToStaticCallRector;
use _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass;
use _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\NewToStaticCall;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class NewToStaticCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Transform\Rector\New_\NewToStaticCallRector::class => [\_PhpScopere8e811afab72\Rector\Transform\Rector\New_\NewToStaticCallRector::TYPE_TO_STATIC_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\NewToStaticCall(\_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass::class, \_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass::class, 'run')]]];
    }
}
