<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\String_\ToStringToMethodCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\String_\ToStringToMethodCallRector;
use RectorPrefix20210208\Symfony\Component\Config\ConfigCache;
use RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileInfo;
final class ToStringToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Transform\Rector\String_\ToStringToMethodCallRector::class => [\Rector\Transform\Rector\String_\ToStringToMethodCallRector::METHOD_NAMES_BY_TYPE => [\RectorPrefix20210208\Symfony\Component\Config\ConfigCache::class => 'getPath']]];
    }
}
