<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\Identical;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\GetClassToInstanceOfRector\GetClassToInstanceOfRectorTest
 */
final class GetClassToInstanceOfRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes comparison with get_class to instanceof', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('if (EventsListener::class === get_class($event->job)) { }', 'if ($event->job instanceof EventsListener) { }')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($node, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
            return $this->isClassReference($node);
        }, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
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
        if ($firstExpr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            $className = $this->getValue($firstExpr);
        } else {
            $className = $this->getName($firstExpr->class);
        }
        if ($className === null) {
            return null;
        }
        $instanceof = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_($varNode, new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($className));
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($instanceof);
        }
        return $instanceof;
    }
    private function isClassReference(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch && $this->isName($node->name, 'class')) {
            return \true;
        }
        // might be
        return $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
    }
    private function isGetClassFuncCallNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->isName($node, 'get_class');
    }
}
