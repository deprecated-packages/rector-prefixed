<?php

declare (strict_types=1);
namespace Rector\Php70\Tests\Rector\FuncCall\RandomFunctionRector;

use Iterator;
use Rector\Php70\Rector\FuncCall\RandomFunctionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210120\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * Some tests copied from https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/2.12/tests/Fixer/Alias/RandomApiMigrationFixerTest.php
 */
final class RandomFunctionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210120\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Php70\Rector\FuncCall\RandomFunctionRector::class;
    }
}
