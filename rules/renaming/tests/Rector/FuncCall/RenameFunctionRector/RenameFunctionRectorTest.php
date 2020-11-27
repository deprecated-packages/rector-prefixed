<?php

declare (strict_types=1);
namespace Rector\Renaming\Tests\Rector\FuncCall\RenameFunctionRector;

use Iterator;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class RenameFunctionRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class => [\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => ['view' => '_PhpScoperbd5d0c5f7638\\Laravel\\Templating\\render', 'sprintf' => '_PhpScoperbd5d0c5f7638\\Safe\\sprintf']]];
    }
}
