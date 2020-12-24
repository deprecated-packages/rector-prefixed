<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersion;
use _PhpScopere8e811afab72\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class Php56Test extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp56');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersion::PHP_56;
    }
}
