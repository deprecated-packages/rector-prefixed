<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\ClassMethod\RenameAnnotationRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameAnnotationRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::RENAMED_ANNOTATIONS_IN_TYPES => [new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\TestCase', 'scenario', 'test')]]];
    }
}
