<?php

declare (strict_types=1);
namespace Rector\Doctrine\PhpDocParser\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
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
    public function createVarTagIntValueNode() : \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode
    {
        $identifierTypeNode = new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('int');
        return new \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode($identifierTypeNode, '', '');
    }
    public function createIdColumnTagValueNode() : \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode
    {
        return $this->columnTagValueNodeFactory->createFromItems(['type' => 'integer']);
    }
}
