<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\PseudoNamespaceToNamespace;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class PseudoNamespaceToNamespaceRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::NAMESPACE_PREFIXES_WITH_EXCLUDED_CLASSES => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\PseudoNamespaceToNamespace('PHPUnit_', ['PHPUnit_Framework_MockObject_MockObject']), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\PseudoNamespaceToNamespace('ChangeMe_', ['KeepMe_']), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\PseudoNamespaceToNamespace('Rector_Renaming_Tests_Rector_FileWithoutNamespace_PseudoNamespaceToNamespaceRector_Fixture_')]]];
    }
}
