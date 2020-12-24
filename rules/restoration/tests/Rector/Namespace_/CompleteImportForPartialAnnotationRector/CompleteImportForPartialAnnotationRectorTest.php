<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\Tests\Rector\Namespace_\CompleteImportForPartialAnnotationRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector;
use _PhpScopere8e811afab72\Rector\Restoration\ValueObject\UseWithAlias;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class CompleteImportForPartialAnnotationRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector::class => [\_PhpScopere8e811afab72\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector::USE_IMPORTS_TO_RESTORE => [new \_PhpScopere8e811afab72\Rector\Restoration\ValueObject\UseWithAlias('_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping', 'ORM')]]];
    }
}
