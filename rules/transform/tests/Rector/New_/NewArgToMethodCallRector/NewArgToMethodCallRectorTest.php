<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\New_\NewArgToMethodCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\New_\NewArgToMethodCallRector;
use Rector\Transform\Tests\Rector\New_\NewArgToMethodCallRector\Source\SomeDotenv;
use Rector\Transform\ValueObject\NewArgToMethodCall;
use RectorPrefix20210206\Symplify\SmartFileSystem\SmartFileInfo;
final class NewArgToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210206\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\New_\NewArgToMethodCallRector::class => [\Rector\Transform\Rector\New_\NewArgToMethodCallRector::NEW_ARGS_TO_METHOD_CALLS => [new \Rector\Transform\ValueObject\NewArgToMethodCall(\Rector\Transform\Tests\Rector\New_\NewArgToMethodCallRector\Source\SomeDotenv::class, \true, 'usePutenv')]]];
    }
}
