<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector;

use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\NetteKdyby\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ReplaceEventManagerWithEventSubscriberRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    public function test() : void
    {
        $fixtureFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/fixture.php.inc');
        $this->doTestFileInfo($fixtureFileInfo);
        $expectedEventFilePath = $this->originalTempFileInfo->getPath() . '/Event/SomeClassCopyEvent.php';
        $this->assertFileExists($expectedEventFilePath);
        $this->assertFileEquals(__DIR__ . '/Source/ExpectedSomeClassCopyEvent.php', $expectedEventFilePath);
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\NetteKdyby\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1;
    }
}
