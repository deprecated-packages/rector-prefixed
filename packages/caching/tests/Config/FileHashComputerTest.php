<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Caching\Tests\Config;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Caching\Config\FileHashComputer;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class FileHashComputerTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var FileHashComputer
     */
    private $fileHashComputer;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel::class);
        $this->fileHashComputer = $this->getService(\_PhpScoper0a6b37af0871\Rector\Caching\Config\FileHashComputer::class);
    }
    /**
     * @dataProvider provideDataForIdenticalHash()
     */
    public function testHashIsIdentical(string $firstConfig, string $secondConfig) : void
    {
        $configAHash = $this->fileHashComputer->compute(new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($firstConfig));
        $configBHash = $this->fileHashComputer->compute(new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($secondConfig));
        $this->assertSame($configAHash, $configBHash);
    }
    public function provideDataForIdenticalHash() : \Iterator
    {
        (yield [__DIR__ . '/Source/config_content_a.yaml', __DIR__ . '/Source/config_content_b.yaml']);
        (yield [__DIR__ . '/Source/Import/import_a.yaml', __DIR__ . '/Source/Import/import_b.yaml']);
    }
    public function testInvalidType() : void
    {
        $this->expectException(\_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException::class);
        $this->fileHashComputer->compute(new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/file.xml'));
    }
}
