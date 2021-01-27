<?php

declare (strict_types=1);
namespace Rector\Php74\Tests\Rector\Function_\ReservedFnFunctionRector;

use Iterator;
use Rector\Php74\Rector\Function_\ReservedFnFunctionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo;
final class ReservedFnFunctionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Php74\Rector\Function_\ReservedFnFunctionRector::class => [\Rector\Php74\Rector\Function_\ReservedFnFunctionRector::RESERVED_NAMES_TO_NEW_ONES => [
            // for testing purposes of "fn" even on PHP 7.3-
            'reservedFn' => 'f',
        ]]];
    }
}
