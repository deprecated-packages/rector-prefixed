<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfo;

use _PhpScoper0a6b37af0871\PhpParser\Comment\Doc;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
final class PhpDocInfoTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocInfoPrinter = $this->getService(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter::class);
        $this->docBlockManipulator = $this->getService(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator::class);
        $this->smartFileSystem = $this->getService(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->phpDocInfo = $this->createPhpDocInfoFromFile(__DIR__ . '/Source/doc.txt');
    }
    public function testGetTagsByName() : void
    {
        $paramTags = $this->phpDocInfo->getTagsByName('param');
        $this->assertCount(2, $paramTags);
    }
    public function testGetVarType() : void
    {
        $expectedObjectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType('SomeType');
        $this->assertEquals($expectedObjectType, $this->phpDocInfo->getVarType());
    }
    public function testGetReturnType() : void
    {
        $expectedObjectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType('SomeType');
        $this->assertEquals($expectedObjectType, $this->phpDocInfo->getReturnType());
    }
    public function testReplaceTagByAnother() : void
    {
        $phpDocInfo = $this->createPhpDocInfoFromFile(__DIR__ . '/Source/test-tag.txt');
        $this->docBlockManipulator->replaceTagByAnother($phpDocInfo->getPhpDocNode(), 'test', 'flow');
        $this->assertStringEqualsFile(__DIR__ . '/Source/expected-replaced-tag.txt', $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo));
    }
    private function createPhpDocInfoFromFile(string $path) : \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $phpDocInfoFactory = $this->getService(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory::class);
        $phpDocContent = $this->smartFileSystem->readFile($path);
        $this->node = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop();
        $this->node->setDocComment(new \_PhpScoper0a6b37af0871\PhpParser\Comment\Doc($phpDocContent));
        return $phpDocInfoFactory->createFromNode($this->node);
    }
}
