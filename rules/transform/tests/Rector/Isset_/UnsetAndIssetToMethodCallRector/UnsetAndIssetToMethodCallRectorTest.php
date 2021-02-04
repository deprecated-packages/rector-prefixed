<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\Isset_\UnsetAndIssetToMethodCallRector;
use Rector\Transform\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer;
use Rector\Transform\ValueObject\IssetUnsetToMethodCall;
use RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo;
final class UnsetAndIssetToMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Transform\Rector\Isset_\UnsetAndIssetToMethodCallRector::class => [\Rector\Transform\Rector\Isset_\UnsetAndIssetToMethodCallRector::ISSET_UNSET_TO_METHOD_CALL => [new \Rector\Transform\ValueObject\IssetUnsetToMethodCall(\Rector\Transform\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer::class, 'hasService', 'removeService')]]];
    }
}
