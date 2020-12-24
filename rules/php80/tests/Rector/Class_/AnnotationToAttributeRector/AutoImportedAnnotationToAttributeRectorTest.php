<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\Tests\Rector\Class_\AnnotationToAttributeRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class AutoImportedAnnotationToAttributeRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureAutoImported');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\Php80\Rector\Class_\AnnotationToAttributeRector::class;
    }
}
