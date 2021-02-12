<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter;

use Iterator;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use Rector\Core\HttpKernel\RectorKernel;
use RectorPrefix20210212\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use RectorPrefix20210212\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractPhpDocInfoPrinterTest extends \RectorPrefix20210212\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocInfoFactory = $this->getService(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory::class);
        $this->phpDocInfoPrinter = $this->getService(\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter::class);
        $this->smartFileSystem = $this->getService(\RectorPrefix20210212\Symplify\SmartFileSystem\SmartFileSystem::class);
    }
    protected function createPhpDocInfoFromDocCommentAndNode(string $docComment, \PhpParser\Node $node) : \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $node->setDocComment(new \PhpParser\Comment\Doc($docComment));
        return $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
    }
    protected function yieldFilesFromDirectory(string $directory, string $suffix = '*.php') : \Iterator
    {
        return \RectorPrefix20210212\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory($directory, $suffix);
    }
}
