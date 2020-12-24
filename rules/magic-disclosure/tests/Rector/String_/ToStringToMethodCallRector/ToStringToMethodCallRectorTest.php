<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\MagicDisclosure\Tests\Rector\String_\ToStringToMethodCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symfony\Component\Config\ConfigCache;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class ToStringToMethodCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector::class => [\_PhpScoper0a6b37af0871\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector::METHOD_NAMES_BY_TYPE => [\_PhpScoper0a6b37af0871\Symfony\Component\Config\ConfigCache::class => 'getPath']]];
    }
}
