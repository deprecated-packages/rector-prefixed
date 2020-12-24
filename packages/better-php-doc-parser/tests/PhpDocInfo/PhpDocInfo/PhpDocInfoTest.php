<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfo;

use _PhpScopere8e811afab72\PhpParser\Comment\Doc;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class PhpDocInfoTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->phpDocInfoPrinter = $this->getService(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter::class);
        $this->docBlockManipulator = $this->getService(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator::class);
        $this->smartFileSystem = $this->getService(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->phpDocInfo = $this->createPhpDocInfoFromFile(__DIR__ . '/Source/doc.txt');
    }
    public function testGetTagsByName() : void
    {
        $paramTags = $this->phpDocInfo->getTagsByName('param');
        $this->assertCount(2, $paramTags);
    }
    public function testGetVarType() : void
    {
        $expectedObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType('SomeType');
        $this->assertEquals($expectedObjectType, $this->phpDocInfo->getVarType());
    }
    public function testGetReturnType() : void
    {
        $expectedObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType('SomeType');
        $this->assertEquals($expectedObjectType, $this->phpDocInfo->getReturnType());
    }
    public function testReplaceTagByAnother() : void
    {
        $phpDocInfo = $this->createPhpDocInfoFromFile(__DIR__ . '/Source/test-tag.txt');
        $this->docBlockManipulator->replaceTagByAnother($phpDocInfo->getPhpDocNode(), 'test', 'flow');
        $this->assertStringEqualsFile(__DIR__ . '/Source/expected-replaced-tag.txt', $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo));
    }
    private function createPhpDocInfoFromFile(string $path) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $phpDocInfoFactory = $this->getService(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory::class);
        $phpDocContent = $this->smartFileSystem->readFile($path);
        $this->node = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop();
        $this->node->setDocComment(new \_PhpScopere8e811afab72\PhpParser\Comment\Doc($phpDocContent));
        return $phpDocInfoFactory->createFromNode($this->node);
    }
}
