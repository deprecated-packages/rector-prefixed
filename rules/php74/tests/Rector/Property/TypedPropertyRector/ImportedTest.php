<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php74\Tests\Rector\Property\TypedPropertyRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Php74\Rector\Property\TypedPropertyRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class ImportedTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureImported');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Php74\Rector\Property\TypedPropertyRector::class;
    }
}
