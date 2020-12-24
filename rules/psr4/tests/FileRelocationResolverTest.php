<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PSR4\Tests;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoperb75b35f52b74\Rector\PSR4\FileRelocationResolver;
use _PhpScoperb75b35f52b74\Rector\PSR4\Tests\Source\SomeFile;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class FileRelocationResolverTest extends \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var FileRelocationResolver
     */
    private $fileRelocationResolver;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel::class);
        $this->fileRelocationResolver = $this->getService(\_PhpScoperb75b35f52b74\Rector\PSR4\FileRelocationResolver::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, string $oldClass, string $newClass, string $expectedNewFileLocation) : void
    {
        $smartFileInfo = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo($file);
        $newFileLocation = $this->fileRelocationResolver->resolveNewFileLocationFromOldClassToNewClass($smartFileInfo, $oldClass, $newClass);
        $this->assertSame($expectedNewFileLocation, $newFileLocation);
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/SomeFile.php', \_PhpScoperb75b35f52b74\Rector\PSR4\Tests\Source\SomeFile::class, '_PhpScoperb75b35f52b74\\Rector\\PSR10\\Tests\\Source\\SomeFile', 'rules/psr4/tests/Source/SomeFile.php']);
    }
}
