<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Tests\Rector\ClassMethod\ArgumentDefaultValueReplacerRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see https://github.com/symfony/symfony/commit/912fc4de8fd6de1e5397be4a94d39091423e5188
 */
final class Symfony28Test extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureSymfony28');
    }
    protected function provideConfigFileInfo() : ?\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/../../../../../../config/set/symfony28.php');
    }
}
