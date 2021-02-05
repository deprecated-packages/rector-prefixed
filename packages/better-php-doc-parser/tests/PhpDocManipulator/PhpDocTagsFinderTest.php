<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocManipulator;

use PhpParser\Node\Stmt\Nop;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagsFinder;
use Rector\Core\Configuration\CurrentNodeProvider;
use Rector\Core\HttpKernel\RectorKernel;
use RectorPrefix20210205\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileSystem;
final class PhpDocTagsFinderTest extends \RectorPrefix20210205\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var PhpDocTagsFinder
     */
    private $phpDocTagsFinder;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var CurrentNodeProvider
     */
    private $currentNodeProvider;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocTagsFinder = $this->getService(\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTagsFinder::class);
        $this->smartFileSystem = $this->getService(\RectorPrefix20210205\Symplify\SmartFileSystem\SmartFileSystem::class);
        // required for parser
        $this->currentNodeProvider = $this->getService(\Rector\Core\Configuration\CurrentNodeProvider::class);
        $this->currentNodeProvider->setNode(new \PhpParser\Node\Stmt\Nop());
    }
    public function test() : void
    {
        $docContent = $this->smartFileSystem->readFile(__DIR__ . '/Source/doc_block_throws.txt');
        $throwsTags = $this->phpDocTagsFinder->extractTrowsTypesFromDocBlock($docContent);
        $this->assertCount(3, $throwsTags);
        $this->assertSame(['A', 'B', 'C'], $throwsTags);
    }
}
