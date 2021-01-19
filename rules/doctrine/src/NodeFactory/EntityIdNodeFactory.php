<?php

declare (strict_types=1);
namespace Rector\Doctrine\NodeFactory;

use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Doctrine\PhpDocParser\Ast\PhpDoc\PhpDocTagNodeFactory;
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
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\Doctrine\PhpDocParser\Ast\PhpDoc\PhpDocTagNodeFactory $phpDocTagNodeFactory, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocTagNodeFactory = $phpDocTagNodeFactory;
        $this->nodeFactory = $nodeFactory;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function createIdProperty() : \PhpParser\Node\Stmt\Property
    {
        $uuidProperty = $this->nodeFactory->createPrivateProperty('id');
        $this->decoratePropertyWithIdAnnotations($uuidProperty);
        return $uuidProperty;
    }
    private function decoratePropertyWithIdAnnotations(\PhpParser\Node\Stmt\Property $property) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
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
