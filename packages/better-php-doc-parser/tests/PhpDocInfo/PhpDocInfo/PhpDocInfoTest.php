<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfo;

use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Stmt\Nop;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockTagReplacer;
use RectorPrefix20210128\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileSystem;
final class PhpDocInfoTest extends \RectorPrefix20210128\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var PhpDocInfo
     */
    private $phpDocInfo;
    /**
     * @var PhpDocInfoPrinter
     */
    private $phpDocInfoPrinter;
    /**
     * @var Node
     */
    private $node;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var DocBlockTagReplacer
     */
    private $docBlockTagReplacer;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocInfoPrinter = $this->getService(\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter::class);
        $this->smartFileSystem = $this->getService(\RectorPrefix20210128\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->docBlockTagReplacer = $this->getService(\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockTagReplacer::class);
        $this->phpDocInfo = $this->createPhpDocInfoFromFile(__DIR__ . '/Source/doc.txt');
    }
    public function testGetTagsByName() : void
    {
        $paramTags = $this->phpDocInfo->getTagsByName('param');
        $this->assertCount(2, $paramTags);
    }
    public function testGetVarType() : void
    {
        $expectedObjectType = new \PHPStan\Type\ObjectType('SomeType');
        $this->assertEquals($expectedObjectType, $this->phpDocInfo->getVarType());
    }
    public function testGetReturnType() : void
    {
        $expectedObjectType = new \PHPStan\Type\ObjectType('SomeType');
        $this->assertEquals($expectedObjectType, $this->phpDocInfo->getReturnType());
    }
    public function testReplaceTagByAnother() : void
    {
        $phpDocInfo = $this->createPhpDocInfoFromFile(__DIR__ . '/Source/test-tag.txt');
        $this->docBlockTagReplacer->replaceTagByAnother($phpDocInfo, 'test', 'flow');
        $printedPhpDocInfo = $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo);
        $this->assertStringEqualsFile(__DIR__ . '/Source/expected-replaced-tag.txt', $printedPhpDocInfo);
    }
    private function createPhpDocInfoFromFile(string $path) : \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $phpDocInfoFactory = $this->getService(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory::class);
        $phpDocContent = $this->smartFileSystem->readFile($path);
        $this->node = new \PhpParser\Node\Stmt\Nop();
        $this->node->setDocComment(new \PhpParser\Comment\Doc($phpDocContent));
        return $phpDocInfoFactory->createFromNode($this->node);
    }
}
