<?php

declare (strict_types=1);
namespace Rector\Naming\Tests\Rector\ClassMethod\RenameParamToMatchTypeRector;

use Iterator;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @requires PHP 8.0
 */
final class Php80Test extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp80');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \Rector\Core\ValueObject\PhpVersion::PHP_80;
    }
}
