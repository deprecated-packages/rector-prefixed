<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class DifferentBundleNameRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return \_PhpScopere8e811afab72\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector::class;
    }
}
