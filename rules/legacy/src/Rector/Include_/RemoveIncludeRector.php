<?php

declare (strict_types=1);
namespace Rector\Legacy\Rector\Include_;

use PhpParser\Node;
use PhpParser\Node\Expr\Include_;
use PhpParser\Node\Stmt\Nop;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/3679
 *
 * @see \Rector\Legacy\Tests\Rector\Include_\RemoveIncludeRector\RemoveIncludeRectorTest
 */
final class RemoveIncludeRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove includes (include, include_once, require, require_once) from source', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
// Comment before require
include 'somefile.php';
// Comment after require
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// Comment before require

// Comment after require
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Include_::class];
    }
    /**
     * @param Include_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $nop = new \PhpParser\Node\Stmt\Nop();
        $comments = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS);
        if ($comments) {
            $nop->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $comments);
            $this->addNodeAfterNode($nop, $node);
        }
        $this->removeNode($node);
        return $node;
    }
}
