<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\Class_\RemoveEmptyAbstractClassRector;

use Iterator;
use Rector\DeadCode\Rector\Class_\RemoveEmptyAbstractClassRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210307\Symplify\SmartFileSystem\SmartFileInfo;
final class ExtraFilesTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @param SmartFileInfo[] $extraFileInfos
     */
    public function test(\RectorPrefix20210307\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, array $extraFileInfos = []) : void
    {
        $this->doTestFileInfo($originalFileInfo, $extraFileInfos);
    }
    public function provideData() : \Iterator
    {
        $extraFileInfos = [new \RectorPrefix20210307\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/UseAbstract.php')];
        (yield [new \RectorPrefix20210307\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/FixtureExtraFiles/SkipUsedAbstractClass.php.inc'), $extraFileInfos]);
        $extraFileInfos = [new \RectorPrefix20210307\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/AbstractMain.php'), new \RectorPrefix20210307\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/AbstractChild.php')];
        (yield [new \RectorPrefix20210307\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/FixtureExtraFiles/ExtendsAbstractChild.php.inc'), $extraFileInfos]);
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\Class_\RemoveEmptyAbstractClassRector::class;
    }
}
