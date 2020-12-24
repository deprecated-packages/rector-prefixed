<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Restoration\Tests\Rector\Namespace_\CompleteImportForPartialAnnotationRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Restoration\ValueObject\UseWithAlias;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class CompleteImportForPartialAnnotationRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector::USE_IMPORTS_TO_RESTORE => [new \_PhpScoper2a4e7ab1ecbc\Rector\Restoration\ValueObject\UseWithAlias('_PhpScoper2a4e7ab1ecbc\\Doctrine\\ORM\\Mapping', 'ORM')]]];
    }
}
