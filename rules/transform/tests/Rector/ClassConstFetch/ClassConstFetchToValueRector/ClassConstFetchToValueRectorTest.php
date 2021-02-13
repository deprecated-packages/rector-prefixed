<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\ClassConstFetch\ClassConstFetchToValueRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo;
final class ClassConstFetchToValueRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function provideConfigFilePath() : string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
