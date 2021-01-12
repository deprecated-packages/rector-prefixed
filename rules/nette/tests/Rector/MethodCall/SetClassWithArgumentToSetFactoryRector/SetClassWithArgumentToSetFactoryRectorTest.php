<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\SetClassWithArgumentToSetFactoryRector;

use Iterator;
use Rector\Nette\Rector\MethodCall\SetClassWithArgumentToSetFactoryRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210112\Symplify\SmartFileSystem\SmartFileInfo;
final class SetClassWithArgumentToSetFactoryRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210112\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Nette\Rector\MethodCall\SetClassWithArgumentToSetFactoryRector::class;
    }
}
