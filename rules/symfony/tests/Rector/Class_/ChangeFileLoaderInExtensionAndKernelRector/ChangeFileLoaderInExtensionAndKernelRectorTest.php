<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony\Tests\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class ChangeFileLoaderInExtensionAndKernelRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::class => [\_PhpScoperb75b35f52b74\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::FROM => 'xml', \_PhpScoperb75b35f52b74\Rector\Symfony\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector::TO => 'yaml']];
    }
}
