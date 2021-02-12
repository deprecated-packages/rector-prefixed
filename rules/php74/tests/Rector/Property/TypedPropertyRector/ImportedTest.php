<?php

declare (strict_types=1);
namespace Rector\Php74\Tests\Rector\Property\TypedPropertyRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo;
final class ImportedTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureImported');
    }
    protected function provideConfigFileInfo() : ?\RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/config/imported_type.php');
    }
}
