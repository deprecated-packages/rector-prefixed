<?php

declare (strict_types=1);
namespace Rector\Symfony5\Tests\Rector\MethodCall\ValidatorBuilderEnableAnnotationMappingRector;

use Iterator;
use Rector\Symfony5\Rector\MethodCall\ValidatorBuilderEnableAnnotationMappingRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo;
final class ValidatorBuilderEnableAnnotationMappingRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210211\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Symfony5\Rector\MethodCall\ValidatorBuilderEnableAnnotationMappingRector::class;
    }
}
