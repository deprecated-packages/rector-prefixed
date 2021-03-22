<?php

declare (strict_types=1);
namespace Rector\Doctrine\NodeFactory;

use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Doctrine\PhpDoc\Node\Property_\GeneratedValueTagValueNode;
use Rector\Doctrine\PhpDoc\Node\Property_\IdTagValueNode;
use Rector\Doctrine\PhpDoc\NodeFactory\Property_\ColumnTagValueNodeFactory;
final class EntityIdNodeFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var ArrayPartPhpDocTagPrinter
     */
    private $arrayPartPhpDocTagPrinter;
    /**
     * @var TagValueNodePrinter
     */
    private $tagValueNodePrinter;
    /**
     * @var ColumnTagValueNodeFactory
     */
    private $columnTagValueNodeFactory;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter, \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter, \Rector\Doctrine\PhpDoc\NodeFactory\Property_\ColumnTagValueNodeFactory $columnTagValueNodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->arrayPartPhpDocTagPrinter = $arrayPartPhpDocTagPrinter;
        $this->tagValueNodePrinter = $tagValueNodePrinter;
        $this->columnTagValueNodeFactory = $columnTagValueNodeFactory;
    }
    public function createIdProperty() : \PhpParser\Node\Stmt\Property
    {
        $idProperty = $this->nodeFactory->createPrivateProperty('id');
        $this->decoratePropertyWithIdAnnotations($idProperty);
        return $idProperty;
    }
    private function decoratePropertyWithIdAnnotations(\PhpParser\Node\Stmt\Property $property) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        // add @var int
        $identifierTypeNode = new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode('int');
        $varTagValueNode = new \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode($identifierTypeNode, '', '');
        $phpDocInfo->addTagValueNode($varTagValueNode);
        // add @ORM\Id
        $idTagValueNode = new \Rector\Doctrine\PhpDoc\Node\Property_\IdTagValueNode($this->arrayPartPhpDocTagPrinter, $this->tagValueNodePrinter);
        $phpDocInfo->addTagValueNodeWithShortName($idTagValueNode);
        $idColumnTagValueNode = $this->columnTagValueNodeFactory->createFromItems(['type' => 'integer']);
        $phpDocInfo->addTagValueNodeWithShortName($idColumnTagValueNode);
        $generatedValueTagValueNode = new \Rector\Doctrine\PhpDoc\Node\Property_\GeneratedValueTagValueNode($this->arrayPartPhpDocTagPrinter, $this->tagValueNodePrinter, ['strategy' => 'AUTO']);
        $phpDocInfo->addTagValueNodeWithShortName($generatedValueTagValueNode);
    }
}
