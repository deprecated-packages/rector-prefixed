<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DowngradePhp71\Rector\Array_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\Array_\SymmetricArrayDestructuringToListRector\SymmetricArrayDestructuringToListRectorTest
 */
final class SymmetricArrayDestructuringToListRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Downgrade Symmetric array destructuring to list() function', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('[$id1, $name1] = $data;', 'list($id1, $name1) = $data;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_::class];
    }
    /**
     * @param Array_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $parentNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign && $this->areNodesEqual($node, $parentNode->var)) {
            return $this->processToList($node);
        }
        if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_ && $this->areNodesEqual($node, $parentNode->valueVar)) {
            return $this->processToList($node);
        }
        return null;
    }
    private function processToList(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_ $array) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall
    {
        $args = [];
        foreach ($array->items as $arrayItem) {
            if (!$arrayItem instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            $args[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($arrayItem->value);
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('list'), $args);
    }
}
