<?php

declare (strict_types=1);
namespace Rector\Doctrine\PhpDocParser\Ast\PhpDoc;

use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode;
use Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode;
use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\BetterPhpDocParser\ValueObject\AroundSpaces;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode;
use Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Doctrine\ColumnTagValueNodeFactory;
use Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Doctrine\JoinColumnTagValueNodeFactory;
use Rector\Doctrine\Uuid\JoinTableNameResolver;
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
    /**
     * @var ColumnTagValueNodeFactory
     */
    private $columnTagValueNodeFactory;
    /**
     * @var ArrayPartPhpDocTagPrinter
     */
    private $arrayPartPhpDocTagPrinter;
    /**
     * @var TagValueNodePrinter
     */
    private $tagValueNodePrinter;
    /**
     * @var JoinColumnTagValueNodeFactory
     */
    private $joinColumnTagValueNodeFactory;
    public function __construct(\Rector\Doctrine\Uuid\JoinTableNameResolver $joinTableNameResolver, \Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Doctrine\ColumnTagValueNodeFactory $columnTagValueNodeFactory, \Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter, \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter, \Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Doctrine\JoinColumnTagValueNodeFactory $joinColumnTagValueNodeFactory)
    {
        $this->joinTableNameResolver = $joinTableNameResolver;
        $this->columnTagValueNodeFactory = $columnTagValueNodeFactory;
        $this->arrayPartPhpDocTagPrinter = $arrayPartPhpDocTagPrinter;
        $this->tagValueNodePrinter = $tagValueNodePrinter;
        $this->joinColumnTagValueNodeFactory = $joinColumnTagValueNodeFactory;
    }
    public function createVarTagIntValueNode() : \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        return $this->createVarTagValueNodeWithType(new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('int'));
    }
    public function createUuidInterfaceVarTagValueNode() : \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        $identifierTypeNode = new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('Ramsey\\Uuid\\UuidInterface');
        return $this->createVarTagValueNodeWithType($identifierTypeNode);
    }
    public function createIdColumnTagValueNode() : \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        return $this->columnTagValueNodeFactory->createFromItems(['type' => 'integer']);
    }
    public function createUuidColumnTagValueNode(bool $isNullable) : \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        return $this->columnTagValueNodeFactory->createFromItems(['type' => 'uuid_binary', 'unique' => \true, 'nullable' => $isNullable ? \true : null]);
    }
    public function createJoinTableTagNode(\PhpParser\Node\Stmt\Property $property) : \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
    {
        $uuidJoinTable = $this->joinTableNameResolver->resolveManyToManyUuidTableNameForProperty($property);
        $joinColumnTagValueNode = $this->joinColumnTagValueNodeFactory->createFromItems(['referencedColumnName' => self::UUID]);
        $uuidJoinColumnTagValueNodes = [$joinColumnTagValueNode];
        $joinTableTagValueNode = new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode($this->arrayPartPhpDocTagPrinter, $this->tagValueNodePrinter, $uuidJoinTable, null, $uuidJoinColumnTagValueNodes, $uuidJoinColumnTagValueNodes, '', new \Rector\BetterPhpDocParser\ValueObject\AroundSpaces('', ''), new \Rector\BetterPhpDocParser\ValueObject\AroundSpaces('', ''));
        return new \Rector\BetterPhpDocParser\Attributes\Ast\PhpDoc\SpacelessPhpDocTagNode($joinTableTagValueNode->getShortName(), $joinTableTagValueNode);
    }
    public function createJoinColumnTagNode(bool $isNullable) : \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode
    {
        return $this->joinColumnTagValueNodeFactory->createFromItems(['referencedColumn' => self::UUID, 'nullable' => $isNullable]);
    }
    private function createVarTagValueNodeWithType(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode) : \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        return new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode($typeNode, '', '');
    }
}
