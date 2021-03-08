<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver;

use Iterator;
use RectorPrefix20210308\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use RectorPrefix20210308\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyFetchTypeResolverTest extends \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\AbstractPropertyFetchTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210308\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->doTestFileInfo($smartFileInfo);
    }
    public function provideData() : \Iterator
    {
        return \RectorPrefix20210308\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectoryExclusively(__DIR__ . '/Fixture');
    }
}
