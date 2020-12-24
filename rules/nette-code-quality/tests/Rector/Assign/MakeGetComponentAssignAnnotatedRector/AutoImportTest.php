<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\Tests\Rector\Assign\MakeGetComponentAssignAnnotatedRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class AutoImportTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureAutoImport');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Assign\MakeGetComponentAssignAnnotatedRector::class;
    }
}
