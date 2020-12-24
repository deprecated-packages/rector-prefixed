<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector;
use _PhpScoper0a6b37af0871\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector\Source\FoodRecipeInterface;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class OrderPublicInterfaceMethodRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::class => [\_PhpScoper0a6b37af0871\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::METHOD_ORDER_BY_INTERFACES => [\_PhpScoper0a6b37af0871\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector\Source\FoodRecipeInterface::class => ['getDescription', 'process']]]];
    }
}
