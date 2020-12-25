<?php

declare (strict_types=1);
namespace Rector\SymfonyPHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToSetUpMethodRector;

use Iterator;
use Rector\SymfonyPHPUnit\Rector\Class_\SelfContainerGetMethodCallFromTestToSetUpMethodRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class SelfContainerGetMethodCallFromTestToSetUpMethodRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\SymfonyPHPUnit\Rector\Class_\SelfContainerGetMethodCallFromTestToSetUpMethodRector::class;
    }
}
