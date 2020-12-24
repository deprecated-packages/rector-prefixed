<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter;

use Iterator;
use _PhpScoper0a6b37af0871\PhpParser\Comment\Doc;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractPhpDocInfoPrinterTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var PhpDocInfoPrinter
     */
    protected $phpDocInfoPrinter;
    /**
     * @var SmartFileSystem
     */
    protected $smartFileSystem;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocInfoFactory = $this->getService(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory::class);
        $this->phpDocInfoPrinter = $this->getService(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter::class);
        $this->smartFileSystem = $this->getService(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem::class);
    }
    protected function createPhpDocInfoFromDocCommentAndNode(string $docComment, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $node->setDocComment(new \_PhpScoper0a6b37af0871\PhpParser\Comment\Doc($docComment));
        $phpDocInfo = $this->phpDocInfoFactory->createFromNode($node);
        if ($phpDocInfo === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $phpDocInfo;
    }
    protected function yieldFilesFromDirectory(string $directory, string $suffix = '*.php') : \Iterator
    {
        return \_PhpScoper0a6b37af0871\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory($directory, $suffix);
    }
}
