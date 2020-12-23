<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\Identical;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Instanceof_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\GetClassToInstanceOfRector\GetClassToInstanceOfRectorTest
 */
final class GetClassToInstanceOfRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes comparison with get_class to instanceof', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('if (EventsListener::class === get_class($event->job)) { }', 'if ($event->job instanceof EventsListener) { }')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($node, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            return $this->isClassReference($node);
        }, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            return $this->isGetClassFuncCallNode($node);
        });
        if ($twoNodeMatch === null) {
            return null;
        }
        /** @var ClassConstFetch|String_ $firstExpr */
        $firstExpr = $twoNodeMatch->getFirstExpr();
        /** @var FuncCall $funcCall */
        $funcCall = $twoNodeMatch->getSecondExpr();
        $varNode = $funcCall->args[0]->value;
        if ($firstExpr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            $className = $this->getValue($firstExpr);
        } else {
            $className = $this->getName($firstExpr->class);
        }
        if ($className === null) {
            return null;
        }
        $instanceof = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Instanceof_($varNode, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($className));
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot($instanceof);
        }
        return $instanceof;
    }
    private function isClassReference(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch && $this->isName($node->name, 'class')) {
            return \true;
        }
        // might be
        return $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
    }
    private function isGetClassFuncCallNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->isName($node, 'get_class');
    }
}
