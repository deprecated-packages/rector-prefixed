<?php

declare (strict_types=1);
namespace Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector;

use Iterator;
use Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector;
use Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer;
use Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210116\Symplify\SmartFileSystem\SmartFileInfo;
final class UnsetAndIssetToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210116\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector::class => [\Rector\MagicDisclosure\Rector\Isset_\UnsetAndIssetToMethodCallRector::ISSET_UNSET_TO_METHOD_CALL => [new \Rector\MagicDisclosure\ValueObject\IssetUnsetToMethodCall(\Rector\MagicDisclosure\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer::class, 'hasService', 'removeService')]]];
    }
}
