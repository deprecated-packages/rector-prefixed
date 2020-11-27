<?php

declare (strict_types=1);
namespace Rector\Symfony\Tests\Rector\MethodCall\FormTypeInstanceToClassConstRector;

use Iterator;
use Rector\Symfony\Rector\MethodCall\FormTypeInstanceToClassConstRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class FormTypeInstanceToClassConstRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \Rector\Symfony\Rector\MethodCall\FormTypeInstanceToClassConstRector::class;
    }
}
