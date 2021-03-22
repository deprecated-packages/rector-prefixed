<?php

declare (strict_types=1);
namespace Rector\Doctrine\PhpDoc\NodeFactory\Class_;

use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\Doctrine\PhpDoc\Node\Class_\EntityTagValueNode;
final class EntityTagValueNodeFactory
{
    /**
     * @var ArrayPartPhpDocTagPrinter
     */
    private $arrayPartPhpDocTagPrinter;
    /**
     * @var TagValueNodePrinter
     */
    private $tagValueNodePrinter;
    public function __construct(\Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter, \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter)
    {
        $this->arrayPartPhpDocTagPrinter = $arrayPartPhpDocTagPrinter;
        $this->tagValueNodePrinter = $tagValueNodePrinter;
    }
    public function create() : \Rector\Doctrine\PhpDoc\Node\Class_\EntityTagValueNode
    {
        return $this->createFromItems([]);
    }
    /**
     * @param array<string, mixed> $items
     */
    public function createFromItems(array $items) : \Rector\Doctrine\PhpDoc\Node\Class_\EntityTagValueNode
    {
        return new \Rector\Doctrine\PhpDoc\Node\Class_\EntityTagValueNode($this->arrayPartPhpDocTagPrinter, $this->tagValueNodePrinter, $items);
    }
}
