<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PSR4\Tests;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\PSR4\FileRelocationResolver;
use _PhpScopere8e811afab72\Rector\PSR4\Tests\Source\SomeFile;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class FileRelocationResolverTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var FileRelocationResolver
     */
    private $fileRelocationResolver;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->fileRelocationResolver = $this->getService(\_PhpScopere8e811afab72\Rector\PSR4\FileRelocationResolver::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, string $oldClass, string $newClass, string $expectedNewFileLocation) : void
    {
        $smartFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($file);
        $newFileLocation = $this->fileRelocationResolver->resolveNewFileLocationFromOldClassToNewClass($smartFileInfo, $oldClass, $newClass);
        $this->assertSame($expectedNewFileLocation, $newFileLocation);
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/SomeFile.php', \_PhpScopere8e811afab72\Rector\PSR4\Tests\Source\SomeFile::class, '_PhpScopere8e811afab72\\Rector\\PSR10\\Tests\\Source\\SomeFile', 'rules/psr4/tests/Source/SomeFile.php']);
    }
}
