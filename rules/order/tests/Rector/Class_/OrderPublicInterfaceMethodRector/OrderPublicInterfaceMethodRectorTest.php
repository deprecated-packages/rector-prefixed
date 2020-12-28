<?php

declare (strict_types=1);
namespace Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector;

use Iterator;
use Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector;
use Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector\Source\FoodRecipeInterface;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo;
final class OrderPublicInterfaceMethodRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::class => [\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::METHOD_ORDER_BY_INTERFACES => [\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector\Source\FoodRecipeInterface::class => ['getDescription', 'process']]]];
    }
}
