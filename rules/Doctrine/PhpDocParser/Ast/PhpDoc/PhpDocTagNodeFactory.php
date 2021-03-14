<?php

declare (strict_types=1);
namespace Rector\Doctrine\PhpDocParser\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Doctrine\ColumnTagValueNodeFactory;
final class PhpDocTagNodeFactory
{
    /**
     * @var ColumnTagValueNodeFactory
     */
    private $columnTagValueNodeFactory;
    public function __construct(\Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Doctrine\ColumnTagValueNodeFactory $columnTagValueNodeFactory)
    {
        $this->columnTagValueNodeFactory = $columnTagValueNodeFactory;
    }
    public function createVarTagIntValueNode() : \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode
    {
        $identifierTypeNode = new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('int');
        return new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode($identifierTypeNode, '', '');
    }
    public function createIdColumnTagValueNode() : \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        return $this->columnTagValueNodeFactory->createFromItems(['type' => 'integer']);
    }
}
