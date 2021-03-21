<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Symfony;

use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\Symfony\PhpDoc\Node\SymfonyRouteTagValueNode;
final class SymfonyRouteTagValueNodeFactory
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
    public function create() : \Rector\Symfony\PhpDoc\Node\SymfonyRouteTagValueNode
    {
        return $this->createFromItems([]);
    }
    /**
     * @param array<string, mixed> $items
     */
    public function createFromItems(array $items) : \Rector\Symfony\PhpDoc\Node\SymfonyRouteTagValueNode
    {
        return new \Rector\Symfony\PhpDoc\Node\SymfonyRouteTagValueNode($this->arrayPartPhpDocTagPrinter, $this->tagValueNodePrinter, $items);
    }
}
