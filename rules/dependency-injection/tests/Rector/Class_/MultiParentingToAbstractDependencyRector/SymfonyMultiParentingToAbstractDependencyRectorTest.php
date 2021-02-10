<?php

declare (strict_types=1);
namespace Rector\DependencyInjection\Tests\Rector\Class_\MultiParentingToAbstractDependencyRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210210\Symplify\SmartFileSystem\SmartFileInfo;
final class SymfonyMultiParentingToAbstractDependencyRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210210\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureSymfony');
    }
    protected function provideConfigFileInfo() : ?\RectorPrefix20210210\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \RectorPrefix20210210\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/config/symfony_config.php');
    }
}
