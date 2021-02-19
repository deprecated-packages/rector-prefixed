<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector;

use Iterator;
use Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210219\Symplify\SmartFileSystem\SmartFileInfo;
final class UseMessageVariableForSprintfInSymfonyStyleRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210219\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector::class;
    }
}
