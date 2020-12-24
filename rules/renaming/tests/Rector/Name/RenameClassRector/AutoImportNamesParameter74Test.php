<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\PostRector\Rector\NameImportingPostRector
 */
final class AutoImportNamesParameter74Test extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     * @requires PHP 7.4
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureAutoImportNames74');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [
            # this class causes to "partial_expression.php.inc" to fail
            \_PhpScopere8e811afab72\Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector::class => [],
            \_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [\_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class]],
        ];
    }
}
