<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Restoration\Tests\Rector\Namespace_\CompleteImportForPartialAnnotationRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector;
use _PhpScoper0a6b37af0871\Rector\Restoration\ValueObject\UseWithAlias;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class CompleteImportForPartialAnnotationRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector::class => [\_PhpScoper0a6b37af0871\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector::USE_IMPORTS_TO_RESTORE => [new \_PhpScoper0a6b37af0871\Rector\Restoration\ValueObject\UseWithAlias('_PhpScoper0a6b37af0871\\Doctrine\\ORM\\Mapping', 'ORM')]]];
    }
}
