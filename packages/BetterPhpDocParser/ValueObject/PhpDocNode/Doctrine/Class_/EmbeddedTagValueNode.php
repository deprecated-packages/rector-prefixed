<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_;

use Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
final class EmbeddedTagValueNode extends \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface
{
    /**
     * @var string
     */
    private $fullyQualifiedClassName;
    /**
     * @param \Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter
     * @param \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter
     * @param mixed[] $items
     * @param string|null $originalContent
     * @param string $fullyQualifiedClassName
     */
    public function __construct($arrayPartPhpDocTagPrinter, $tagValueNodePrinter, $items, $originalContent, $fullyQualifiedClassName)
    {
        parent::__construct($arrayPartPhpDocTagPrinter, $tagValueNodePrinter, $items, $originalContent);
        $this->fullyQualifiedClassName = $fullyQualifiedClassName;
    }
    public function getShortName() : string
    {
        return '@ORM\\Embedded';
    }
    public function getColumnPrefix() : ?string
    {
        return $this->items['columnPrefix'];
    }
    public function getTargetEntity() : ?string
    {
        return $this->items['class'];
    }
    public function getFullyQualifiedTargetEntity() : ?string
    {
        return $this->fullyQualifiedClassName;
    }
    /**
     * @param string $targetEntity
     */
    public function changeTargetEntity($targetEntity) : void
    {
        $this->items['class'] = $targetEntity;
    }
}
