<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector;
use _PhpScoper0a2ac50786fa\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector\Source\FoodRecipeInterface;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class OrderPublicInterfaceMethodRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::class => [\_PhpScoper0a2ac50786fa\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::METHOD_ORDER_BY_INTERFACES => [\_PhpScoper0a2ac50786fa\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector\Source\FoodRecipeInterface::class => ['getDescription', 'process']]]];
    }
}
