<?php

declare (strict_types=1);
namespace Rector\Downgrade\Tests\Rector\LNumber\ChangePhpVersionInPlatformCheckRector;

use Iterator;
use Rector\Downgrade\Rector\LNumber\ChangePhpVersionInPlatformCheckRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ChangePhpVersionInPlatformCheckRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return mixed[]
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Downgrade\Rector\LNumber\ChangePhpVersionInPlatformCheckRector::class => [\Rector\Downgrade\Rector\LNumber\ChangePhpVersionInPlatformCheckRector::TARGET_PHP_VERSION => 70100]];
    }
}
