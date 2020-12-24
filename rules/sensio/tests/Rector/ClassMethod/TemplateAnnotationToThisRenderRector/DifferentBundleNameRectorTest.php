<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class DifferentBundleNameRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return \_PhpScoper2a4e7ab1ecbc\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector::class;
    }
}
