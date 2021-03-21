<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Kdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210321\Symplify\SmartFileSystem\SmartFileInfo;
final class ReplaceMagicPropertyEventWithEventClassRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    public function testSkip() : void
    {
        $fixtureFileInfo = new \RectorPrefix20210321\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/skip_on_success_in_control.php.inc');
        $this->doTestFileInfo($fixtureFileInfo);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210321\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, string $expectedRelativeFilePath, string $expectedContentFilePath) : void
    {
        $this->doTestFileInfo($fixtureFileInfo);
        $this->doTestExtraFile($expectedRelativeFilePath, $expectedContentFilePath);
    }
    /**
     * @return Iterator<mixed>
     */
    public function provideData() : \Iterator
    {
        (yield [new \RectorPrefix20210321\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/simple_event.php.inc'), '/Event/FileManagerUploadEvent.php', __DIR__ . '/Source/ExpectedFileManagerUploadEvent.php']);
        (yield [new \RectorPrefix20210321\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/duplicated_event_params.php.inc'), '/Event/DuplicatedEventParamsUploadEvent.php', __DIR__ . '/Source/ExpectedDuplicatedEventParamsUploadEvent.php']);
    }
    public function provideConfigFilePath() : string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
