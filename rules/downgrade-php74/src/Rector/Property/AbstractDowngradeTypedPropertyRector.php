<?php

declare (strict_types=1);
namespace Rector\DowngradePhp74\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Rector\AbstractRector;
use Rector\DowngradePhp74\Contract\Rector\DowngradeTypedPropertyRectorInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractDowngradeTypedPropertyRector extends \Rector\Core\Rector\AbstractRector implements \Rector\DowngradePhp74\Contract\Rector\DowngradeTypedPropertyRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
    private function decoratePropertyWithDocBlock(\PhpParser\Node\Stmt\Property $property, \PhpParser\Node $typeNode) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
