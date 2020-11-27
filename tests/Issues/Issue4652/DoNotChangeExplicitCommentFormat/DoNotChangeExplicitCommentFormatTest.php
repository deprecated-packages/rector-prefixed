<?php

declare (strict_types=1);
namespace Rector\Core\Tests\Issues\Issue4652\DoNotChangeExplicitCommentFormat;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class DoNotChangeExplicitCommentFormatTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
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
    // bin/rector process ... --config config/some_config.php
    protected function provideConfigFileInfo() : \Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/config/some_config.php');
    }
}
