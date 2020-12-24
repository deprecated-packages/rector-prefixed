<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector;
use _PhpScopere8e811afab72\Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer;
use _PhpScopere8e811afab72\Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class UnsetAndIssetToMethodCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector::class => [\_PhpScopere8e811afab72\Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector::ISSET_UNSET_TO_METHOD_CALL => [new \_PhpScopere8e811afab72\Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall(\_PhpScopere8e811afab72\Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer::class, 'hasService', 'removeService')]]];
    }
}
