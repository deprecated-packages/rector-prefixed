<?php

declare (strict_types=1);
namespace Rector\MagicDisclosure\Tests\Rector\String_\ToStringToMethodCallRector;

use Iterator;
use Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper17db12703726\Symfony\Component\Config\ConfigCache;
use Symplify\SmartFileSystem\SmartFileInfo;
final class ToStringToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector::class => [\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector::METHOD_NAMES_BY_TYPE => [\_PhpScoper17db12703726\Symfony\Component\Config\ConfigCache::class => 'getPath']]];
    }
}
