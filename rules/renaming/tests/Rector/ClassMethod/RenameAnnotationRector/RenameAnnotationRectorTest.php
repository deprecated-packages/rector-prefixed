<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\ClassMethod\RenameAnnotationRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameAnnotationRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::class => [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::RENAMED_ANNOTATIONS_IN_TYPES => [new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestCase', 'scenario', 'test')]]];
    }
}
