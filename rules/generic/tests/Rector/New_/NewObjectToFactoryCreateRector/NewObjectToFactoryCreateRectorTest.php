<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\New_\NewObjectToFactoryCreateRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClassFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class NewObjectToFactoryCreateRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\New_\NewObjectToFactoryCreateRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\New_\NewObjectToFactoryCreateRector::OBJECT_TO_FACTORY_METHOD => [\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass::class => ['class' => \_PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClassFactory::class, 'method' => 'create']]]];
    }
}
