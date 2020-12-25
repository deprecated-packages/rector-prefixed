<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\FuncCall\FuncCallToStaticCallRector;

use Iterator;
use Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\ValueObject\FuncCallToStaticCall;
use Symplify\SmartFileSystem\SmartFileInfo;
final class FuncCallToStaticCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::class => [\Rector\Generic\Rector\FuncCall\FuncCallToStaticCallRector::FUNC_CALLS_TO_STATIC_CALLS => [new \Rector\Transform\ValueObject\FuncCallToStaticCall('view', 'SomeStaticClass', 'render'), new \Rector\Transform\ValueObject\FuncCallToStaticCall('_PhpScoperbf340cb0be9d\\SomeNamespaced\\view', 'AnotherStaticClass', 'render')]]];
    }
}
