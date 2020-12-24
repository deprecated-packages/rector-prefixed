<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoManipulator;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait PhpDocTrait
{
    /**
     * @var PhpDocInfoPrinter
     */
    protected $phpDocInfoPrinter;
    /**
     * @var PhpDocInfoFactory
     */
    protected $phpDocInfoFactory;
    /**
     * @var PhpDocInfoManipulator
     */
    protected $phpDocInfoManipulator;
    /**
     * @required
     */
    public function autowirePhpDocTrait(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter $phpDocInfoPrinter, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoManipulator $phpDocInfoManipulator) : void
    {
        $this->phpDocInfoPrinter = $phpDocInfoPrinter;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->phpDocInfoManipulator = $phpDocInfoManipulator;
    }
    protected function hasTagByName(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $tagName) : bool
    {
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return \false;
        }
        return $phpDocInfo->hasByName($tagName);
    }
    protected function getPhpDocTagValueNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $phpDocTagNodeClass) : ?\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        return $this->phpDocInfoManipulator->getPhpDocTagValueNode($node, $phpDocTagNodeClass);
    }
    protected function hasPhpDocTagValueNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $phpDocTagNodeClass) : bool
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        return $phpDocInfo->hasByType($phpDocTagNodeClass);
    }
    protected function removePhpDocTagValueNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $phpDocTagNodeClass) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $phpDocInfo->removeByType($phpDocTagNodeClass);
    }
}
