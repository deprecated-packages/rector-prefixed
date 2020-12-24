<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector;
use _PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\ClassWithStaticProperties;
use _PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\FirstStaticClass;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class SingleStaticServiceToDynamicRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector::class => [\_PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\Class_\SingleStaticServiceToDynamicRector::CLASS_TYPES => ['_PhpScoperb75b35f52b74\\Rector\\RemovingStatic\\Tests\\Rector\\Class_\\SingleStaticServiceToDynamicRector\\Fixture\\Fixture', '_PhpScoperb75b35f52b74\\Rector\\RemovingStatic\\Tests\\Rector\\Class_\\SingleStaticServiceToDynamicRector\\Fixture\\StaticProperties', \_PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\FirstStaticClass::class, \_PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\SingleStaticServiceToDynamicRector\Source\ClassWithStaticProperties::class]]];
    }
}
