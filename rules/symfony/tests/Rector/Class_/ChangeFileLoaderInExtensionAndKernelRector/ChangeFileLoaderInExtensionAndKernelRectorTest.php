<?php

declare (strict_types=1);
namespace Rector\Symfony\Tests\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector;

use Iterator;
use Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210119\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeFileLoaderInExtensionAndKernelRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210119\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::class => [\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::FROM => 'xml', \Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::TO => 'yaml']];
    }
}
