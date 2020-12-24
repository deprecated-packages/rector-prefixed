<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\RemovingStatic\Rector\Class_\StaticTypeToSetterInjectionRector;
use _PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactory;
use _PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactoryWithInterface;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticTypeToSetterInjectionRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\RemovingStatic\Rector\Class_\StaticTypeToSetterInjectionRector::class => [\_PhpScoper0a6b37af0871\Rector\RemovingStatic\Rector\Class_\StaticTypeToSetterInjectionRector::STATIC_TYPES => [
            \_PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactory::class,
            // with adding a parent interface to the class
            'ParentSetterEnforcingInterface' => \_PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactoryWithInterface::class,
        ]]];
    }
}
