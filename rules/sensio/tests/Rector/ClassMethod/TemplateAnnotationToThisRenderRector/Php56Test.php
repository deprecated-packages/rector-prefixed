<?php

declare (strict_types=1);
namespace Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;

use Iterator;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210119\Symplify\SmartFileSystem\SmartFileInfo;
final class Php56Test extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210119\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp56');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \Rector\Core\ValueObject\PhpVersion::PHP_56;
    }
}
