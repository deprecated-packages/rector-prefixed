<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\Rector\New_\NewObjectToFactoryCreateRector;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass;
use _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClassFactory;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class NewObjectToFactoryCreateRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Generic\Rector\New_\NewObjectToFactoryCreateRector::class => [\_PhpScopere8e811afab72\Rector\Generic\Rector\New_\NewObjectToFactoryCreateRector::OBJECT_TO_FACTORY_METHOD => [\_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass::class => ['class' => \_PhpScopere8e811afab72\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClassFactory::class, 'method' => 'create']]]];
    }
}
