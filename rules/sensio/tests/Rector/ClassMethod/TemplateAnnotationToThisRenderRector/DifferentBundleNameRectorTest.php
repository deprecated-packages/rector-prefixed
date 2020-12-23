<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class DifferentBundleNameRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return \_PhpScoper0a2ac50786fa\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector::class;
    }
}
