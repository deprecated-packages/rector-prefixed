<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector;

use Iterator;
use Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector;
use Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\ClassWithStaticProperties;
use Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\FirstStaticClass;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210109\Symplify\SmartFileSystem\SmartFileInfo;
final class SingleStaticServiceToDynamicRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210109\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector::class => [\Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector::CLASS_TYPES => ['Rector\\RemovingStatic\\Tests\\Rector\\Class_\\SingleStaticServiceToDynamicRector\\Fixture\\Fixture', 'Rector\\RemovingStatic\\Tests\\Rector\\Class_\\SingleStaticServiceToDynamicRector\\Fixture\\StaticProperties', \Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\FirstStaticClass::class, \Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\ClassWithStaticProperties::class]]];
    }
}
