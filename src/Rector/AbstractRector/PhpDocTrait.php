<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoManipulator;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function autowirePhpDocTrait(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer\PhpDocInfoPrinter $phpDocInfoPrinter, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoManipulator $phpDocInfoManipulator) : void
    {
        $this->phpDocInfoPrinter = $phpDocInfoPrinter;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->phpDocInfoManipulator = $phpDocInfoManipulator;
    }
    protected function hasTagByName(\_PhpScopere8e811afab72\PhpParser\Node $node, string $tagName) : bool
    {
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return \false;
        }
        return $phpDocInfo->hasByName($tagName);
    }
    protected function getPhpDocTagValueNode(\_PhpScopere8e811afab72\PhpParser\Node $node, string $phpDocTagNodeClass) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        return $this->phpDocInfoManipulator->getPhpDocTagValueNode($node, $phpDocTagNodeClass);
    }
    protected function hasPhpDocTagValueNode(\_PhpScopere8e811afab72\PhpParser\Node $node, string $phpDocTagNodeClass) : bool
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        return $phpDocInfo->hasByType($phpDocTagNodeClass);
    }
    protected function removePhpDocTagValueNode(\_PhpScopere8e811afab72\PhpParser\Node $node, string $phpDocTagNodeClass) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $phpDocInfo->removeByType($phpDocTagNodeClass);
    }
}
