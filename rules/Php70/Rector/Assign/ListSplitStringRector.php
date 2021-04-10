<?php

declare (strict_types=1);
namespace Rector\Php70\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\List_;
use PHPStan\Type\StringType;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @source http://php.net/manual/en/migration70.incompatible.php#migration70.incompatible.variable-handling.list
 *
 * @changelog https://stackoverflow.com/a/47965344/1348344
 * @see \Rector\Tests\Php70\Rector\Assign\ListSplitStringRector\ListSplitStringRectorTest
 */
final class ListSplitStringRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('list() cannot split string directly anymore, use str_split()', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('list($foo) = "string";', 'list($foo) = str_split("string");')]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$node->var instanceof \PhpParser\Node\Expr\List_) {
            return null;
        }
        if (!$this->nodeTypeResolver->isStaticType($node->expr, \PHPStan\Type\StringType::class)) {
            return null;
        }
        $node->expr = $this->nodeFactory->createFuncCall('str_split', [$node->expr]);
        return $node;
    }
}
