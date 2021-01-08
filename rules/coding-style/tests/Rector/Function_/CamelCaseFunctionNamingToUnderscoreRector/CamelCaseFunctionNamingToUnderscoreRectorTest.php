<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\Function_\CamelCaseFunctionNamingToUnderscoreRector;

use Iterator;
use Rector\CodingStyle\Rector\Function_\CamelCaseFunctionNamingToUnderscoreRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210108\Symplify\SmartFileSystem\SmartFileInfo;
final class CamelCaseFunctionNamingToUnderscoreRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210108\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodingStyle\Rector\Function_\CamelCaseFunctionNamingToUnderscoreRector::class;
    }
}
