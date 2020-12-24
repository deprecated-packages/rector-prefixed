<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php74\Tests\Rector\Function_\ReservedFnFunctionRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Php74\Rector\Function_\ReservedFnFunctionRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ReservedFnFunctionRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Php74\Rector\Function_\ReservedFnFunctionRector::class => [\_PhpScoperb75b35f52b74\Rector\Php74\Rector\Function_\ReservedFnFunctionRector::RESERVED_NAMES_TO_NEW_ONES => [
            // for testing purposes of "fn" even on PHP 7.3-
            'reservedFn' => 'f',
        ]]];
    }
}
