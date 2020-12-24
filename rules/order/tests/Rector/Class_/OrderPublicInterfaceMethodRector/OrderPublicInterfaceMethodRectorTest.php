<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector;
use _PhpScoperb75b35f52b74\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector\Source\FoodRecipeInterface;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class OrderPublicInterfaceMethodRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::class => [\_PhpScoperb75b35f52b74\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::METHOD_ORDER_BY_INTERFACES => [\_PhpScoperb75b35f52b74\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector\Source\FoodRecipeInterface::class => ['getDescription', 'process']]]];
    }
}
