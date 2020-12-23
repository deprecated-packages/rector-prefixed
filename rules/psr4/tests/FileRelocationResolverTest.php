<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PSR4\Tests;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a2ac50786fa\Rector\PSR4\FileRelocationResolver;
use _PhpScoper0a2ac50786fa\Rector\PSR4\Tests\Source\SomeFile;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class FileRelocationResolverTest extends \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var FileRelocationResolver
     */
    private $fileRelocationResolver;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a2ac50786fa\Rector\Core\HttpKernel\RectorKernel::class);
        $this->fileRelocationResolver = self::$container->get(\_PhpScoper0a2ac50786fa\Rector\PSR4\FileRelocationResolver::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, string $oldClass, string $newClass, string $expectedNewFileLocation) : void
    {
        $smartFileInfo = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo($file);
        $newFileLocation = $this->fileRelocationResolver->resolveNewFileLocationFromOldClassToNewClass($smartFileInfo, $oldClass, $newClass);
        $this->assertSame($expectedNewFileLocation, $newFileLocation);
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/SomeFile.php', \_PhpScoper0a2ac50786fa\Rector\PSR4\Tests\Source\SomeFile::class, '_PhpScoper0a2ac50786fa\\Rector\\PSR10\\Tests\\Source\\SomeFile', 'rules/psr4/tests/Source/SomeFile.php']);
    }
}
