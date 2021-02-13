<?php

declare (strict_types=1);
namespace Rector\Naming\Tests\Rector\Class_\RenamePropertyToMatchTypeRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @requires PHP 8.0
 */
final class Php80Test extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210213\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp80');
    }
    protected function provideConfigFilePath() : string
    {
        return __DIR__ . '/config/property_promotion.php';
    }
}
