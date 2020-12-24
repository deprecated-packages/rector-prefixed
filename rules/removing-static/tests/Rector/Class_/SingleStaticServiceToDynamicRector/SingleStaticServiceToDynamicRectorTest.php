<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector;
use _PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\ClassWithStaticProperties;
use _PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\FirstStaticClass;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class SingleStaticServiceToDynamicRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector::class => [\_PhpScoper0a6b37af0871\Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector::CLASS_TYPES => ['_PhpScoper0a6b37af0871\\Rector\\RemovingStatic\\Tests\\Rector\\Class_\\SingleStaticServiceToDynamicRector\\Fixture\\Fixture', '_PhpScoper0a6b37af0871\\Rector\\RemovingStatic\\Tests\\Rector\\Class_\\SingleStaticServiceToDynamicRector\\Fixture\\StaticProperties', \_PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\FirstStaticClass::class, \_PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\ClassWithStaticProperties::class]]];
    }
}
