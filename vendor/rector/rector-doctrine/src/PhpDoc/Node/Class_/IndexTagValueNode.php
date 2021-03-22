<?php

declare (strict_types=1);
namespace Rector\Doctrine\PhpDoc\Node\Class_;

use Rector\BetterPhpDocParser\Contract\PhpDocNode\TagAwareNodeInterface;
use Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter;
use Rector\BetterPhpDocParser\Printer\TagValueNodePrinter;
use Rector\Doctrine\PhpDoc\Node\AbstractDoctrineTagValueNode;
final class IndexTagValueNode extends \Rector\Doctrine\PhpDoc\Node\AbstractDoctrineTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\TagAwareNodeInterface
{
    /**
     * @var string|null
     */
    private $tag;
    public function __construct(\Rector\BetterPhpDocParser\Printer\ArrayPartPhpDocTagPrinter $arrayPartPhpDocTagPrinter, \Rector\BetterPhpDocParser\Printer\TagValueNodePrinter $tagValueNodePrinter, array $items, ?string $content = null, ?string $originalTag = null)
    {
        $this->tag = $originalTag;
        parent::__construct($arrayPartPhpDocTagPrinter, $tagValueNodePrinter, $items, $content);
    }
    public function getTag() : ?string
    {
        return $this->tag ?: $this->getShortName();
    }
    public function getShortName() : string
    {
        return '@ORM\\Index';
    }
}
