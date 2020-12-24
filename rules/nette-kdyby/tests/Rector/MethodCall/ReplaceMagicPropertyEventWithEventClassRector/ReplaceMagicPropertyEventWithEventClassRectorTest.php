<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ReplaceMagicPropertyEventWithEventClassRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    public function testSkip() : void
    {
        $fixtureFileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/skip_on_success_in_control.php.inc');
        $this->doTestFileInfo($fixtureFileInfo);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, string $expectedRelativeFilePath, string $expectedContentFilePath) : void
    {
        $this->doTestFileInfo($fixtureFileInfo);
        $expectedEventFilePath = $this->originalTempFileInfo->getPath() . $expectedRelativeFilePath;
        $this->assertFileExists($expectedEventFilePath);
        $this->assertFileEquals($expectedContentFilePath, $expectedEventFilePath);
    }
    public function provideData() : \Iterator
    {
        (yield [new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/simple_event.php.inc'), '/Event/FileManagerUploadEvent.php', __DIR__ . '/Source/ExpectedFileManagerUploadEvent.php']);
        (yield [new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/duplicated_event_params.php.inc'), '/Event/DuplicatedEventParamsUploadEvent.php', __DIR__ . '/Source/ExpectedDuplicatedEventParamsUploadEvent.php']);
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1;
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\NetteKdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector::class;
    }
}
