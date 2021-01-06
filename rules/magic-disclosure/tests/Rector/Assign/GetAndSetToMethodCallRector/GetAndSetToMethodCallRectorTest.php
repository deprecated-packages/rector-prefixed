<?php

declare (strict_types=1);
namespace Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector;

use Iterator;
use Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector;
use Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\Klarka;
use Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\SomeContainer;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210106\Symplify\SmartFileSystem\SmartFileInfo;
final class GetAndSetToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210106\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector::class => [\Rector\MagicDisclosure\Rector\Assign\GetAndSetToMethodCallRector::TYPE_TO_METHOD_CALLS => [\Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\SomeContainer::class => ['get' => 'getService', 'set' => 'addService'], \Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\Klarka::class => ['get' => 'get']]]];
    }
}
