<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class DifferentBundleNameRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        // prepare bundle path
        $originalBundleFilePath = __DIR__ . '/FixtureDifferentBundleName/SomeActionBundle/DifferentNameBundle.php';
        $temporaryBundleFilePath = $this->getTempPath() . '/DifferentNameBundle.php';
        $this->smartFileSystem->copy($originalBundleFilePath, $temporaryBundleFilePath, \true);
        $this->doTestFileInfo($fileInfo);
        $this->smartFileSystem->remove($temporaryBundleFilePath);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureDifferentBundleName');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector::class;
    }
}
