<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRector;

use Iterator;
use Rector\Nette\Rector\MethodCall\GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return \Rector\Nette\Rector\MethodCall\GetConfigWithDefaultsArgumentToArrayMergeInCompilerExtensionRector::class;
    }
}
