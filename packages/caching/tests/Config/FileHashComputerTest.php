<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Caching\Tests\Config;

use Iterator;
use _PhpScopere8e811afab72\Rector\Caching\Config\FileHashComputer;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class FileHashComputerTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var FileHashComputer
     */
    private $fileHashComputer;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->fileHashComputer = $this->getService(\_PhpScopere8e811afab72\Rector\Caching\Config\FileHashComputer::class);
    }
    /**
     * @dataProvider provideDataForIdenticalHash()
     */
    public function testHashIsIdentical(string $firstConfig, string $secondConfig) : void
    {
        $configAHash = $this->fileHashComputer->compute(new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($firstConfig));
        $configBHash = $this->fileHashComputer->compute(new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($secondConfig));
        $this->assertSame($configAHash, $configBHash);
    }
    public function provideDataForIdenticalHash() : \Iterator
    {
        (yield [__DIR__ . '/Source/config_content_a.yaml', __DIR__ . '/Source/config_content_b.yaml']);
        (yield [__DIR__ . '/Source/Import/import_a.yaml', __DIR__ . '/Source/Import/import_b.yaml']);
    }
    public function testInvalidType() : void
    {
        $this->expectException(\_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException::class);
        $this->fileHashComputer->compute(new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/file.xml'));
    }
}
