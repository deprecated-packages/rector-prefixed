<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\PhpDocParser\Ast\PhpDoc;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\AroundSpaces;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode;
use _PhpScoperb75b35f52b74\Rector\Doctrine\Uuid\JoinTableNameResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Doctrine\Uuid\JoinTableNameResolver $joinTableNameResolver)
    {
        $this->joinTableNameResolver = $joinTableNameResolver;
    }
    public function createVarTagIntValueNode() : \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        return $this->createVarTagValueNodeWithType(new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('int'));
    }
    public function createUuidInterfaceVarTagValueNode() : \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        $identifierTypeNode = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('_PhpScoperb75b35f52b74\\Ramsey\\Uuid\\UuidInterface');
        return $this->createVarTagValueNodeWithType($identifierTypeNode);
    }
    public function createIdColumnTagValueNode() : \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        return new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode(['type' => 'integer']);
    }
    public function createUuidColumnTagValueNode(bool $isNullable) : \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        return new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode(['type' => 'uuid_binary', 'unique' => \true, 'nullable' => $isNullable ? \true : null]);
    }
    public function createJoinTableTagNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
    {
        $uuidJoinTable = $this->joinTableNameResolver->resolveManyToManyUuidTableNameForProperty($property);
        $uuidJoinColumnTagValueNodes = [new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode(['referencedColumnName' => self::UUID])];
        $joinTableTagValueNode = new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode($uuidJoinTable, null, $uuidJoinColumnTagValueNodes, $uuidJoinColumnTagValueNodes, '', new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\AroundSpaces('', ''), new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\AroundSpaces('', ''));
        return new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode($joinTableTagValueNode->getShortName(), $joinTableTagValueNode);
    }
    public function createJoinColumnTagNode(bool $isNullable) : \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode
    {
        return new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode(['referencedColumn' => self::UUID, 'nullable' => $isNullable]);
    }
    private function createVarTagValueNodeWithType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode) : \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode($typeNode, '', '');
    }
}
