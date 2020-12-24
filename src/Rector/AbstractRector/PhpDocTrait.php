<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoManipulator;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function autowirePhpDocTrait(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter $phpDocInfoPrinter, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoManipulator $phpDocInfoManipulator) : void
    {
        $this->phpDocInfoPrinter = $phpDocInfoPrinter;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->phpDocInfoManipulator = $phpDocInfoManipulator;
    }
    protected function hasTagByName(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $tagName) : bool
    {
        $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return \false;
        }
        return $phpDocInfo->hasByName($tagName);
    }
    protected function getPhpDocTagValueNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $phpDocTagNodeClass) : ?\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        return $this->phpDocInfoManipulator->getPhpDocTagValueNode($node, $phpDocTagNodeClass);
    }
    protected function hasPhpDocTagValueNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $phpDocTagNodeClass) : bool
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        return $phpDocInfo->hasByType($phpDocTagNodeClass);
    }
    protected function removePhpDocTagValueNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $phpDocTagNodeClass) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $phpDocInfo->removeByType($phpDocTagNodeClass);
    }
}
