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
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use Symplify\SmartFileSystem\SmartFileSystem;
final class PhpDocInfoTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
     * @var DocBlockManipulator
     */
    private $docBlockManipulator;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocInfoPrinter = self::$container->get(\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter::class);
        $this->docBlockManipulator = self::$container->get(\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator::class);
        $this->smartFileSystem = self::$container->get(\Symplify\SmartFileSystem\SmartFileSystem::class);
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
        $this->docBlockManipulator->replaceTagByAnother($phpDocInfo->getPhpDocNode(), 'test', 'flow');
        $this->assertStringEqualsFile(__DIR__ . '/Source/expected-replaced-tag.txt', $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo));
    }
    private function createPhpDocInfoFromFile(string $path) : \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $phpDocInfoFactory = self::$container->get(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory::class);
        $phpDocContent = $this->smartFileSystem->readFile($path);
        $this->node = new \PhpParser\Node\Stmt\Nop();
        $this->node->setDocComment(new \PhpParser\Comment\Doc($phpDocContent));
        return $phpDocInfoFactory->createFromNode($this->node);
    }
}
