<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Restoration\Tests\Rector\Namespace_\CompleteImportForPartialAnnotationRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector;
use _PhpScoperb75b35f52b74\Rector\Restoration\ValueObject\UseWithAlias;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class CompleteImportForPartialAnnotationRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector::class => [\_PhpScoperb75b35f52b74\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector::USE_IMPORTS_TO_RESTORE => [new \_PhpScoperb75b35f52b74\Rector\Restoration\ValueObject\UseWithAlias('_PhpScoperb75b35f52b74\\Doctrine\\ORM\\Mapping', 'ORM')]]];
    }
}
