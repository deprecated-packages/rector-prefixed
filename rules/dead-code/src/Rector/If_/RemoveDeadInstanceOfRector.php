<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\If_;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\Instanceof_;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\If_;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\NodeManipulator\IfManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\If_\RemoveDeadInstanceOfRector\RemoveDeadInstanceOfRectorTest
 */
final class RemoveDeadInstanceOfRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    public function __construct(\Rector\Core\NodeManipulator\IfManipulator $ifManipulator)
    {
        $this->ifManipulator = $ifManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove dead instanceof check on type hinted variable', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function go(stdClass $stdClass)
    {
        if (! $stdClass instanceof stdClass) {
            return false;
        }
        return true;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function go(stdClass $stdClass)
    {
        return true;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->ifManipulator->isIfWithoutElseAndElseIfs($node)) {
            return null;
        }
        if ($node->cond instanceof \PhpParser\Node\Expr\BooleanNot && $node->cond->expr instanceof \PhpParser\Node\Expr\Instanceof_) {
            return $this->processMayDeadInstanceOf($node, $node->cond->expr);
        }
        if ($node->cond instanceof \PhpParser\Node\Expr\Instanceof_) {
            return $this->processMayDeadInstanceOf($node, $node->cond);
        }
        return $node;
    }
    private function processMayDeadInstanceOf(\PhpParser\Node\Stmt\If_ $if, \PhpParser\Node\Expr\Instanceof_ $instanceof) : ?\PhpParser\Node
    {
        $previousVar = $this->betterNodeFinder->findFirstPrevious($if, function (\PhpParser\Node $node) use($instanceof) : bool {
            if ($node === $instanceof->expr) {
                return \false;
            }
            return $this->areNodesEqual($node, $instanceof->expr);
        });
        if (!$previousVar instanceof \PhpParser\Node) {
            return null;
        }
        $name = $this->getName($instanceof->class);
        if ($name === null) {
            return null;
        }
        $isSameObject = $this->isSameObject($previousVar, $name);
        if (!$isSameObject) {
            return null;
        }
        if ($if->cond === $instanceof) {
            $this->unwrapStmts($if->stmts, $if);
            $this->removeNode($if);
            return null;
        }
        $this->removeNode($if);
        return $if;
    }
    private function isSameObject(\PhpParser\Node $node, string $name) : bool
    {
        $objectType = $this->getObjectType($node);
        $parentPreviousVar = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentPreviousVar instanceof \PhpParser\Node\Param) {
            $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
                return \false;
            }
            $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parentNode instanceof \PhpParser\Node\Expr\Assign) {
                return \false;
            }
            $objectType = $this->getObjectType($parentNode->expr);
            if (!$objectType instanceof \PHPStan\Type\ObjectType) {
                return \false;
            }
            return \is_a($objectType, $name, \true);
        }
        $type = $parentPreviousVar->type;
        if ($type instanceof \PhpParser\Node\Name\FullyQualified) {
            $type = $type->toString();
            return \is_a($type, $name, \true);
        }
        return \false;
    }
}
