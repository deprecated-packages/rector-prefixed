<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\Klarka;
use _PhpScoperb75b35f52b74\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\SomeContainer;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class GetAndSetToMethodCallRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector::class => [\_PhpScoperb75b35f52b74\Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector::TYPE_TO_METHOD_CALLS => [\_PhpScoperb75b35f52b74\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\SomeContainer::class => ['get' => 'getService', 'set' => 'addService'], \_PhpScoperb75b35f52b74\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\Klarka::class => ['get' => 'get']]]];
    }
}
