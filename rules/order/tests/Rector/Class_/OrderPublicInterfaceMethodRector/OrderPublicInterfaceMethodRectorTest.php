<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector;
use _PhpScopere8e811afab72\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector\Source\FoodRecipeInterface;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class OrderPublicInterfaceMethodRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::class => [\_PhpScopere8e811afab72\Rector\Order\Rector\Class_\OrderPublicInterfaceMethodRector::METHOD_ORDER_BY_INTERFACES => [\_PhpScopere8e811afab72\Rector\Order\Tests\Rector\Class_\OrderPublicInterfaceMethodRector\Source\FoodRecipeInterface::class => ['getDescription', 'process']]]];
    }
}
