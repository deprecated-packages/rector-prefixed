<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\New_\NewObjectToFactoryCreateRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass;
use _PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClassFactory;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class NewObjectToFactoryCreateRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\New_\NewObjectToFactoryCreateRector::class => [\_PhpScoper0a6b37af0871\Rector\Generic\Rector\New_\NewObjectToFactoryCreateRector::OBJECT_TO_FACTORY_METHOD => [\_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClass::class => ['class' => \_PhpScoper0a6b37af0871\Rector\Generic\Tests\Rector\New_\NewObjectToFactoryCreateRector\Source\MyClassFactory::class, 'method' => 'create']]]];
    }
}
