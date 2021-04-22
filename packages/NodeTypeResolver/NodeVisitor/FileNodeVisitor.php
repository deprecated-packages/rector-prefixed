<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeVisitor;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use Rector\Core\ValueObject\Application\File;
use Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * Useful for modification of class outside current node tree
 */
final class FileNodeVisitor extends \PhpParser\NodeVisitorAbstract
{
    /**
     * @var File
     */
    private $file;
    public function __construct(\Rector\Core\ValueObject\Application\File $file)
    {
        $this->file = $file;
    }
    /**
     * @return \PhpParser\Node|null
     */
    public function enterNode(\PhpParser\Node $node)
    {
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE, $this->file);
        return $node;
    }
}
