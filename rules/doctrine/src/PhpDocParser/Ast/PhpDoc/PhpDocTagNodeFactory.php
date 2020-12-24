<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Doctrine\PhpDocParser\Ast\PhpDoc;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\AroundSpaces;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Uuid\JoinTableNameResolver;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Doctrine\Uuid\JoinTableNameResolver $joinTableNameResolver)
    {
        $this->joinTableNameResolver = $joinTableNameResolver;
    }
    public function createVarTagIntValueNode() : \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        return $this->createVarTagValueNodeWithType(new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('int'));
    }
    public function createUuidInterfaceVarTagValueNode() : \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        $identifierTypeNode = new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('_PhpScoper0a6b37af0871\\Ramsey\\Uuid\\UuidInterface');
        return $this->createVarTagValueNodeWithType($identifierTypeNode);
    }
    public function createIdColumnTagValueNode() : \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        return new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode(['type' => 'integer']);
    }
    public function createUuidColumnTagValueNode(bool $isNullable) : \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        return new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode(['type' => 'uuid_binary', 'unique' => \true, 'nullable' => $isNullable ? \true : null]);
    }
    public function createJoinTableTagNode(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
    {
        $uuidJoinTable = $this->joinTableNameResolver->resolveManyToManyUuidTableNameForProperty($property);
        $uuidJoinColumnTagValueNodes = [new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode(['referencedColumnName' => self::UUID])];
        $joinTableTagValueNode = new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode($uuidJoinTable, null, $uuidJoinColumnTagValueNodes, $uuidJoinColumnTagValueNodes, '', new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\AroundSpaces('', ''), new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\AroundSpaces('', ''));
        return new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode($joinTableTagValueNode->getShortName(), $joinTableTagValueNode);
    }
    public function createJoinColumnTagNode(bool $isNullable) : \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode
    {
        return new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode(['referencedColumn' => self::UUID, 'nullable' => $isNullable]);
    }
    private function createVarTagValueNodeWithType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode) : \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode($typeNode, '', '');
    }
}
