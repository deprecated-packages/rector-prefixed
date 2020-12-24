<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Comment\Doc;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractPhpDocInfoPrinterTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocInfoFactory = $this->getService(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory::class);
        $this->phpDocInfoPrinter = $this->getService(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter::class);
        $this->smartFileSystem = $this->getService(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem::class);
    }
    protected function createPhpDocInfoFromDocCommentAndNode(string $docComment, \_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $node->setDocComment(new \_PhpScopere8e811afab72\PhpParser\Comment\Doc($docComment));
        $phpDocInfo = $this->phpDocInfoFactory->createFromNode($node);
        if ($phpDocInfo === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $phpDocInfo;
    }
    protected function yieldFilesFromDirectory(string $directory, string $suffix = '*.php') : \Iterator
    {
        return \_PhpScopere8e811afab72\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory($directory, $suffix);
    }
}
