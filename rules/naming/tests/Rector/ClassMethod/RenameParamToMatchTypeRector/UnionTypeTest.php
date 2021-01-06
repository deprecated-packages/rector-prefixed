<?php

declare (strict_types=1);
namespace Rector\Naming\Tests\Rector\ClassMethod\RenameParamToMatchTypeRector;

use Iterator;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210106\Symplify\SmartFileSystem\SmartFileInfo;
final class UnionTypeTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 8.0
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210106\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureUnionType');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \Rector\Core\ValueObject\PhpVersionFeature::UNION_TYPES;
    }
}
