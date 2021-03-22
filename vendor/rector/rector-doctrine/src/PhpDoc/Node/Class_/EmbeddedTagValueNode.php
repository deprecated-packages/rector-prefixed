<?php

declare (strict_types=1);
namespace Rector\Doctrine\PhpDoc\Node\Class_;

use Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\Doctrine\PhpDoc\Node\AbstractDoctrineTagValueNode;
final class EmbeddedTagValueNode extends \Rector\Doctrine\PhpDoc\Node\AbstractDoctrineTagValueNode implements \Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface
{
    /**
     * @var string
     */
    private $fullyQualifiedClassName;
    public function __construct(\Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter, \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter, array $items, ?string $originalContent, string $fullyQualifiedClassName)
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
    public function changeTargetEntity(string $targetEntity) : void
    {
        $this->items['class'] = $targetEntity;
    }
}
