<?php

declare (strict_types=1);
namespace Rector\Naming\Tests\Rector\Class_\RenamePropertyToMatchTypeRector;

use Iterator;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @requires PHP 8.0
 */
final class Php80Test extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp80');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \Rector\Core\ValueObject\PhpVersionFeature::PROPERTY_PROMOTION;
    }
}
