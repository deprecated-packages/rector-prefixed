<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\ClassMethod\RenameAnnotationRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameAnnotationRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScopere8e811afab72\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::RENAMED_ANNOTATIONS_IN_TYPES => [new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'scenario', 'test')]]];
    }
}
