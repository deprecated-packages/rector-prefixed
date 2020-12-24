<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\PseudoNamespaceToNamespace;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class PseudoNamespaceToNamespaceRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::class => [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::NAMESPACE_PREFIXES_WITH_EXCLUDED_CLASSES => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\PseudoNamespaceToNamespace('PHPUnit_', ['PHPUnit_Framework_MockObject_MockObject']), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\PseudoNamespaceToNamespace('ChangeMe_', ['KeepMe_']), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\PseudoNamespaceToNamespace('Rector_Renaming_Tests_Rector_FileWithoutNamespace_PseudoNamespaceToNamespaceRector_Fixture_')]]];
    }
}
