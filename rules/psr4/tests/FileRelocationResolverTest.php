<?php

declare (strict_types=1);
namespace Rector\PSR4\Tests;

use Iterator;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\PSR4\FileRelocationResolver;
use Rector\PSR4\Tests\Source\SomeFile;
use RectorPrefix20210117\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210117\Symplify\SmartFileSystem\SmartFileInfo;
final class FileRelocationResolverTest extends \RectorPrefix20210117\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var FileRelocationResolver
     */
    private $fileRelocationResolver;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->fileRelocationResolver = $this->getService(\Rector\PSR4\FileRelocationResolver::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, string $oldClass, string $newClass, string $expectedNewFileLocation) : void
    {
        $smartFileInfo = new \RectorPrefix20210117\Symplify\SmartFileSystem\SmartFileInfo($file);
        $newFileLocation = $this->fileRelocationResolver->resolveNewFileLocationFromOldClassToNewClass($smartFileInfo, $oldClass, $newClass);
        $this->assertSame($expectedNewFileLocation, $newFileLocation);
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/SomeFile.php', \Rector\PSR4\Tests\Source\SomeFile::class, 'Rector\\PSR10\\Tests\\Source\\SomeFile', 'rules/psr4/tests/Source/SomeFile.php']);
    }
}
