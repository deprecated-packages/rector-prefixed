<?php

declare (strict_types=1);
namespace Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210111\Symplify\SmartFileSystem\SmartFileInfo;
final class NormalizeNamespaceByPSR4ComposerAutoloadRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210111\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->doTestFileInfo($smartFileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function provideConfigFileInfo() : \RectorPrefix20210111\Symplify\SmartFileSystem\SmartFileInfo
    {
        return new \RectorPrefix20210111\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/config/normalize_namespace_without_namespace_config.php');
    }
}
