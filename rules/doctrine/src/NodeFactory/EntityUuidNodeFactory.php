<?php

declare (strict_types=1);
namespace Rector\Doctrine\NodeFactory;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use RectorPrefix20210111\Ramsey\Uuid\Uuid;
use Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Doctrine\PhpDocParser\Ast\PhpDoc\PhpDocTagNodeFactory;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class EntityUuidNodeFactory
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
    public function createTemporaryUuidProperty() : \PhpParser\Node\Stmt\Property
    {
        $uuidProperty = $this->nodeFactory->createPrivateProperty('uuid');
        $this->decoratePropertyWithUuidAnnotations($uuidProperty, \true, \false);
        return $uuidProperty;
    }
    /**
     * Creates:
     * $this->uid = \Ramsey\Uuid\Uuid::uuid4();
     */
    public function createUuidPropertyDefaultValueAssign(string $uuidVariableName) : \PhpParser\Node\Stmt\Expression
    {
        $thisUuidPropertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $uuidVariableName);
        $uuid4StaticCall = $this->nodeFactory->createStaticCall(\RectorPrefix20210111\Ramsey\Uuid\Uuid::class, 'uuid4');
        $assign = new \PhpParser\Node\Expr\Assign($thisUuidPropertyFetch, $uuid4StaticCall);
        return new \PhpParser\Node\Stmt\Expression($assign);
    }
    private function decoratePropertyWithUuidAnnotations(\PhpParser\Node\Stmt\Property $property, bool $isNullable, bool $isId) : void
    {
        $this->clearVarAndOrmAnnotations($property);
        $this->replaceIntSerializerTypeWithString($property);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        // add @var
        $attributeAwareVarTagValueNode = $this->phpDocTagNodeFactory->createUuidInterfaceVarTagValueNode();
        $phpDocInfo->addTagValueNode($attributeAwareVarTagValueNode);
        if ($isId) {
            // add @ORM\Id
            $idTagValueNode = new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode([]);
            $phpDocInfo->addTagValueNodeWithShortName($idTagValueNode);
        }
        $columnTagValueNode = $this->phpDocTagNodeFactory->createUuidColumnTagValueNode($isNullable);
        $phpDocInfo->addTagValueNodeWithShortName($columnTagValueNode);
        if (!$isId) {
            return;
        }
        $generatedValueTagValueNode = new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode(['strategy' => 'CUSTOM']);
        $phpDocInfo->addTagValueNodeWithShortName($generatedValueTagValueNode);
    }
    private function clearVarAndOrmAnnotations(\PhpParser\Node\Stmt\Property $property) : void
    {
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        $phpDocInfo->removeByType(\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
        $phpDocInfo->removeByType(\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface::class);
    }
    /**
     * See https://github.com/ramsey/uuid-doctrine/issues/50#issuecomment-348123520.
     */
    private function replaceIntSerializerTypeWithString(\PhpParser\Node\Stmt\Property $property) : void
    {
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        /** @var SerializerTypeTagValueNode|null $serializerTypeTagValueNode */
        $serializerTypeTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class);
        if ($serializerTypeTagValueNode === null) {
            return;
        }
        $serializerTypeTagValueNode->replaceName('int', 'string');
    }
}
