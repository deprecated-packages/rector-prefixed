<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\MagicDisclosure\Tests\Rector\String_\ToStringToMethodCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symfony\Component\Config\ConfigCache;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ToStringToMethodCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector::class => [\_PhpScoperb75b35f52b74\Rector\MagicDisclosure\Rector\String_\ToStringToMethodCallRector::METHOD_NAMES_BY_TYPE => [\_PhpScoperb75b35f52b74\Symfony\Component\Config\ConfigCache::class => 'getPath']]];
    }
}
