<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\Foreach_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ForeachManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\Foreach_\SimplifyForeachInstanceOfRector\SimplifyForeachInstanceOfRectorTest
 */
final class SimplifyForeachInstanceOfRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ForeachManipulator
     */
    private $foreachManipulator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ForeachManipulator $foreachManipulator)
    {
        $this->foreachManipulator = $foreachManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify unnecessary foreach check of instances', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
foreach ($foos as $foo) {
    $this->assertInstanceOf(SplFileInfo::class, $foo);
}
CODE_SAMPLE
, '$this->assertContainsOnlyInstancesOf(\\SplFileInfo::class, $foos);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        /** @var MethodCall|StaticCall|null $matchedNode */
        $matchedNode = $this->foreachManipulator->matchOnlyStmt($node, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_ $foreachNode) : ?Node {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
                return null;
            }
            if (!$this->isName($node->name, 'assertInstanceOf')) {
                return null;
            }
            if (!$this->areNodesEqual($foreachNode->valueVar, $node->args[1]->value)) {
                return null;
            }
            return $node;
        });
        if ($matchedNode === null) {
            return null;
        }
        /** @var MethodCall|StaticCall $matchedNode */
        $callClass = \get_class($matchedNode);
        return new $callClass($this->resolveVar($matchedNode), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('assertContainsOnlyInstancesOf'), [$matchedNode->args[0], new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($node->expr)]);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function resolveVar(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return $node->var;
        }
        return $node->class;
    }
}
