<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\Property\AnnotatedPropertyInjectToConstructorInjectionRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Property\AnnotatedPropertyInjectToConstructorInjectionRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class TypedPropertyTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureTypedProperty');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Generic\Rector\Property\AnnotatedPropertyInjectToConstructorInjectionRector::class;
    }
}
