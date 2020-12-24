<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see https://github.com/symfony/symfony/commit/912fc4de8fd6de1e5397be4a94d39091423e5188
 */
final class Symfony28Test extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureSymfony28');
    }
    protected function provideConfigFileInfo() : ?\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/../../../../../../config/set/symfony28.php');
    }
}
