<?php

declare (strict_types=1);
namespace Rector\SymfonyPhpConfig\Tests\Rector\MethodCall\AutoInPhpSymfonyConfigRector;

use Iterator;
use Rector\SymfonyPhpConfig\Rector\MethodCall\AutoInPhpSymfonyConfigRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo;
final class AutoInPhpSymfonyConfigRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201228\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\SymfonyPhpConfig\Rector\MethodCall\AutoInPhpSymfonyConfigRector::class;
    }
}
