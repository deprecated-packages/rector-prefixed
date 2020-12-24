<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector;
use _PhpScoper0a6b37af0871\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\Klarka;
use _PhpScoper0a6b37af0871\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\SomeContainer;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class GetAndSetToMethodCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoper0a6b37af0871\Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector::class => [\_PhpScoper0a6b37af0871\Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector::TYPE_TO_METHOD_CALLS => [\_PhpScoper0a6b37af0871\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\SomeContainer::class => ['get' => 'getService', 'set' => 'addService'], \_PhpScoper0a6b37af0871\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\Klarka::class => ['get' => 'get']]]];
    }
}
