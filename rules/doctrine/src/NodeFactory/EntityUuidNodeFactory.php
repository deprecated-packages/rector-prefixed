<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScopere8e811afab72\Ramsey\Uuid\Uuid;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser\Ast\PhpDoc\PhpDocTagNodeFactory;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser\Ast\PhpDoc\PhpDocTagNodeFactory $phpDocTagNodeFactory)
    {
        $this->phpDocTagNodeFactory = $phpDocTagNodeFactory;
        $this->nodeFactory = $nodeFactory;
    }
    public function createTemporaryUuidProperty() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property
    {
        $uuidProperty = $this->nodeFactory->createPrivateProperty('uuid');
        $this->decoratePropertyWithUuidAnnotations($uuidProperty, \true, \false);
        return $uuidProperty;
    }
    /**
     * Creates:
     * $this->uid = \Ramsey\Uuid\Uuid::uuid4();
     */
    public function createUuidPropertyDefaultValueAssign(string $uuidVariableName) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $thisUuidPropertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $uuidVariableName);
        $uuid4StaticCall = $this->nodeFactory->createStaticCall(\_PhpScopere8e811afab72\Ramsey\Uuid\Uuid::class, 'uuid4');
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($thisUuidPropertyFetch, $uuid4StaticCall);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
    }
    private function decoratePropertyWithUuidAnnotations(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, bool $isNullable, bool $isId) : void
    {
        $this->clearVarAndOrmAnnotations($property);
        $this->replaceIntSerializerTypeWithString($property);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        // add @var
        $attributeAwareVarTagValueNode = $this->phpDocTagNodeFactory->createUuidInterfaceVarTagValueNode();
        $phpDocInfo->addTagValueNode($attributeAwareVarTagValueNode);
        if ($isId) {
            // add @ORM\Id
            $idTagValueNode = new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode([]);
            $phpDocInfo->addTagValueNodeWithShortName($idTagValueNode);
        }
        $columnTagValueNode = $this->phpDocTagNodeFactory->createUuidColumnTagValueNode($isNullable);
        $phpDocInfo->addTagValueNodeWithShortName($columnTagValueNode);
        if (!$isId) {
            return;
        }
        $generatedValueTagValueNode = new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode(['strategy' => 'CUSTOM']);
        $phpDocInfo->addTagValueNodeWithShortName($generatedValueTagValueNode);
    }
    private function clearVarAndOrmAnnotations(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : void
    {
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        $phpDocInfo->removeByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
        $phpDocInfo->removeByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface::class);
    }
    /**
     * See https://github.com/ramsey/uuid-doctrine/issues/50#issuecomment-348123520.
     */
    private function replaceIntSerializerTypeWithString(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : void
    {
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return;
        }
        /** @var SerializerTypeTagValueNode|null $serializerTypeTagValueNode */
        $serializerTypeTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class);
        if ($serializerTypeTagValueNode === null) {
            return;
        }
        $serializerTypeTagValueNode->replaceName('int', 'string');
    }
}
