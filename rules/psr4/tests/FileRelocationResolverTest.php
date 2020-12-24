<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PSR4\Tests;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper2a4e7ab1ecbc\Rector\PSR4\FileRelocationResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\PSR4\Tests\Source\SomeFile;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class FileRelocationResolverTest extends \_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var FileRelocationResolver
     */
    private $fileRelocationResolver;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper2a4e7ab1ecbc\Rector\Core\HttpKernel\RectorKernel::class);
        $this->fileRelocationResolver = $this->getService(\_PhpScoper2a4e7ab1ecbc\Rector\PSR4\FileRelocationResolver::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, string $oldClass, string $newClass, string $expectedNewFileLocation) : void
    {
        $smartFileInfo = new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo($file);
        $newFileLocation = $this->fileRelocationResolver->resolveNewFileLocationFromOldClassToNewClass($smartFileInfo, $oldClass, $newClass);
        $this->assertSame($expectedNewFileLocation, $newFileLocation);
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/SomeFile.php', \_PhpScoper2a4e7ab1ecbc\Rector\PSR4\Tests\Source\SomeFile::class, '_PhpScoper2a4e7ab1ecbc\\Rector\\PSR10\\Tests\\Source\\SomeFile', 'rules/psr4/tests/Source/SomeFile.php']);
    }
}
