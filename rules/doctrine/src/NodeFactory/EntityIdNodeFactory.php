<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser\Ast\PhpDoc\PhpDocTagNodeFactory;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class EntityIdNodeFactory
{
    /**
     * @var PhpDocTagNodeFactory
     */
    private $phpDocTagNodeFactory;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser\Ast\PhpDoc\PhpDocTagNodeFactory $phpDocTagNodeFactory)
    {
        $this->phpDocTagNodeFactory = $phpDocTagNodeFactory;
        $this->nodeFactory = $nodeFactory;
    }
    public function createIdProperty() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property
    {
        $uuidProperty = $this->nodeFactory->createPrivateProperty('id');
        $this->decoratePropertyWithIdAnnotations($uuidProperty);
        return $uuidProperty;
    }
    private function decoratePropertyWithIdAnnotations(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        // add @var int
        $attributeAwareVarTagValueNode = $this->phpDocTagNodeFactory->createVarTagIntValueNode();
        $phpDocInfo->addTagValueNode($attributeAwareVarTagValueNode);
        // add @ORM\Id
        $phpDocInfo->addTagValueNodeWithShortName(new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode([]));
        $idColumnTagValueNode = $this->phpDocTagNodeFactory->createIdColumnTagValueNode();
        $phpDocInfo->addTagValueNodeWithShortName($idColumnTagValueNode);
        $generatedValueTagValueNode = new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode(['strategy' => 'AUTO']);
        $phpDocInfo->addTagValueNodeWithShortName($generatedValueTagValueNode);
    }
}
