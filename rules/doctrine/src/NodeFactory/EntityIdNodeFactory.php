<?php

declare (strict_types=1);
namespace Rector\Doctrine\NodeFactory;

use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Doctrine\PhpDocParser\Ast\PhpDoc\PhpDocTagNodeFactory;
use Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\Doctrine\PhpDocParser\Ast\PhpDoc\PhpDocTagNodeFactory $phpDocTagNodeFactory)
    {
        $this->phpDocTagNodeFactory = $phpDocTagNodeFactory;
        $this->nodeFactory = $nodeFactory;
    }
    public function createIdProperty() : \PhpParser\Node\Stmt\Property
    {
        $uuidProperty = $this->nodeFactory->createPrivateProperty('id');
        $this->decoratePropertyWithIdAnnotations($uuidProperty);
        return $uuidProperty;
    }
    private function decoratePropertyWithIdAnnotations(\PhpParser\Node\Stmt\Property $property) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        // add @var int
        $attributeAwareVarTagValueNode = $this->phpDocTagNodeFactory->createVarTagIntValueNode();
        $phpDocInfo->addTagValueNode($attributeAwareVarTagValueNode);
        // add @ORM\Id
        $phpDocInfo->addTagValueNodeWithShortName(new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode([]));
        $idColumnTagValueNode = $this->phpDocTagNodeFactory->createIdColumnTagValueNode();
        $phpDocInfo->addTagValueNodeWithShortName($idColumnTagValueNode);
        $generatedValueTagValueNode = new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode(['strategy' => 'AUTO']);
        $phpDocInfo->addTagValueNodeWithShortName($generatedValueTagValueNode);
    }
}
