<?php

declare (strict_types=1);
namespace Rector\Defluent\Tests\Rector\MethodCall\MethodCallOnSetterMethodCallToStandaloneAssignRector;

use Iterator;
use Rector\Defluent\Rector\MethodCall\MethodCallOnSetterMethodCallToStandaloneAssignRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class MethodCallOnSetterMethodCallToStandaloneAssignRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \Rector\Defluent\Rector\MethodCall\MethodCallOnSetterMethodCallToStandaloneAssignRector::class;
    }
}
