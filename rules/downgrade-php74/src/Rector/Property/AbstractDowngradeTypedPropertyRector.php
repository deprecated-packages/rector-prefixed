<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Property;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Contract\Rector\DowngradeTypedPropertyRectorInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractDowngradeTypedPropertyRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\DowngradePhp74\Contract\Rector\DowngradeTypedPropertyRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->type === null) {
            return null;
        }
        if (!$this->shouldRemoveProperty($node)) {
            return null;
        }
        $this->decoratePropertyWithDocBlock($node, $node->type);
        $node->type = null;
        return $node;
    }
    private function decoratePropertyWithDocBlock(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, \_PhpScopere8e811afab72\PhpParser\Node $typeNode) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($property);
        }
        if ($phpDocInfo->getVarTagValueNode() !== null) {
            return;
        }
        $newType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($typeNode);
        $phpDocInfo->changeVarType($newType);
    }
}
