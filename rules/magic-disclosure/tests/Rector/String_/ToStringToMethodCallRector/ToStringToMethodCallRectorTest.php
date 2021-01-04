<?php

declare (strict_types=1);
namespace Rector\MagicDisclosure\Tests\Rector\String_\ToStringToMethodCallRector;

use Iterator;
use Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210104\Symfony\Component\Config\ConfigCache;
use RectorPrefix20210104\Symplify\SmartFileSystem\SmartFileInfo;
final class ToStringToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210104\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector::class => [\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector::METHOD_NAMES_BY_TYPE => [\RectorPrefix20210104\Symfony\Component\Config\ConfigCache::class => 'getPath']]];
    }
}
