<?php

declare (strict_types=1);
namespace Rector\Generic\Tests\Rector\FuncCall\RemoveFuncCallArgRector;

use Iterator;
use Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector;
use Rector\Generic\ValueObject\RemoveFuncCallArg;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use SplFileInfo;
use RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveFuncCallArgRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210114\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    /**
     * @return Iterator<SplFileInfo>
     */
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::class => [\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::REMOVED_FUNCTION_ARGUMENTS => [new \Rector\Generic\ValueObject\RemoveFuncCallArg('ldap_first_attribute', 2)]]];
    }
}
