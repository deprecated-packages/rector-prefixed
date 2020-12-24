<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony\Tests\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeFileLoaderInExtensionAndKernelRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::class => [\_PhpScopere8e811afab72\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::FROM => 'xml', \_PhpScopere8e811afab72\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::TO => 'yaml']];
    }
}
