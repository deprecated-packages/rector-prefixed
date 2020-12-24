<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser\Ast\PhpDoc;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\AroundSpaces;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode;
use _PhpScopere8e811afab72\Rector\Doctrine\Uuid\JoinTableNameResolver;
final class PhpDocTagNodeFactory
{
    /**
     * @var string
     */
    private const UUID = 'uuid';
    /**
     * @var JoinTableNameResolver
     */
    private $joinTableNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Doctrine\Uuid\JoinTableNameResolver $joinTableNameResolver)
    {
        $this->joinTableNameResolver = $joinTableNameResolver;
    }
    public function createVarTagIntValueNode() : \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        return $this->createVarTagValueNodeWithType(new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('int'));
    }
    public function createUuidInterfaceVarTagValueNode() : \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        $identifierTypeNode = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('_PhpScopere8e811afab72\\Ramsey\\Uuid\\UuidInterface');
        return $this->createVarTagValueNodeWithType($identifierTypeNode);
    }
    public function createIdColumnTagValueNode() : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        return new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode(['type' => 'integer']);
    }
    public function createUuidColumnTagValueNode(bool $isNullable) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        return new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode(['type' => 'uuid_binary', 'unique' => \true, 'nullable' => $isNullable ? \true : null]);
    }
    public function createJoinTableTagNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
    {
        $uuidJoinTable = $this->joinTableNameResolver->resolveManyToManyUuidTableNameForProperty($property);
        $uuidJoinColumnTagValueNodes = [new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode(['referencedColumnName' => self::UUID])];
        $joinTableTagValueNode = new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode($uuidJoinTable, null, $uuidJoinColumnTagValueNodes, $uuidJoinColumnTagValueNodes, '', new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\AroundSpaces('', ''), new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\AroundSpaces('', ''));
        return new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode($joinTableTagValueNode->getShortName(), $joinTableTagValueNode);
    }
    public function createJoinColumnTagNode(bool $isNullable) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode
    {
        return new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode(['referencedColumn' => self::UUID, 'nullable' => $isNullable]);
    }
    private function createVarTagValueNodeWithType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode) : \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode($typeNode, '', '');
    }
}
