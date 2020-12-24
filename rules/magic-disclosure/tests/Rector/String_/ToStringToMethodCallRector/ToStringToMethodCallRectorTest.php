<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\MagicDisclosure\Tests\Rector\String_\ToStringToMethodCallRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symfony\Component\Config\ConfigCache;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ToStringToMethodCallRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector::class => [\_PhpScopere8e811afab72\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector::METHOD_NAMES_BY_TYPE => [\_PhpScopere8e811afab72\Symfony\Component\Config\ConfigCache::class => 'getPath']]];
    }
}
