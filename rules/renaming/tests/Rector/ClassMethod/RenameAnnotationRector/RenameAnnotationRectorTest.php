<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\ClassMethod\RenameAnnotationRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameAnnotationRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::class => [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::RENAMED_ANNOTATIONS_IN_TYPES => [new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'scenario', 'test')]]];
    }
}
