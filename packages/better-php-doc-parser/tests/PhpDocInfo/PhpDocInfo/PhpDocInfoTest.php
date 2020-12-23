<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfo;

use _PhpScoper0a2ac50786fa\PhpParser\Comment\Doc;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Nop;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use _PhpScoper0a2ac50786fa\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem;
final class PhpDocInfoTest extends \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScoper0a2ac50786fa\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocInfoPrinter = self::$container->get(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter::class);
        $this->docBlockManipulator = self::$container->get(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator::class);
        $this->smartFileSystem = self::$container->get(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->phpDocInfo = $this->createPhpDocInfoFromFile(__DIR__ . '/Source/doc.txt');
    }
    public function testGetTagsByName() : void
    {
        $paramTags = $this->phpDocInfo->getTagsByName('param');
        $this->assertCount(2, $paramTags);
    }
    public function testGetVarType() : void
    {
        $expectedObjectType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType('SomeType');
        $this->assertEquals($expectedObjectType, $this->phpDocInfo->getVarType());
    }
    public function testGetReturnType() : void
    {
        $expectedObjectType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType('SomeType');
        $this->assertEquals($expectedObjectType, $this->phpDocInfo->getReturnType());
    }
    public function testReplaceTagByAnother() : void
    {
        $phpDocInfo = $this->createPhpDocInfoFromFile(__DIR__ . '/Source/test-tag.txt');
        $this->docBlockManipulator->replaceTagByAnother($phpDocInfo->getPhpDocNode(), 'test', 'flow');
        $this->assertStringEqualsFile(__DIR__ . '/Source/expected-replaced-tag.txt', $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo));
    }
    private function createPhpDocInfoFromFile(string $path) : \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $phpDocInfoFactory = self::$container->get(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory::class);
        $phpDocContent = $this->smartFileSystem->readFile($path);
        $this->node = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Nop();
        $this->node->setDocComment(new \_PhpScoper0a2ac50786fa\PhpParser\Comment\Doc($phpDocContent));
        return $phpDocInfoFactory->createFromNode($this->node);
    }
}
