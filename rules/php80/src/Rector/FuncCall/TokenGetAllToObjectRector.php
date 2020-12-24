<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Php80\NodeManipulator\TokenManipulator;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/token_as_object
 *
 * @see \Rector\Php80\Tests\Rector\FuncCall\TokenGetAllToObjectRector\TokenGetAllToObjectRectorTest
 */
final class TokenGetAllToObjectRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var TokenManipulator
     */
    private $tokenManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Php80\NodeManipulator\TokenManipulator $ifArrayTokenManipulator)
    {
        $this->tokenManipulator = $ifArrayTokenManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Complete missing constructor dependency instance by type', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $tokens = token_get_all($code);
        foreach ($tokens as $token) {
            if (is_array($token)) {
               $name = token_name($token[0]);
               $text = $token[1];
            } else {
               $name = null;
               $text = $token;
            }
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $tokens = \PhpToken::getAll($code);
        foreach ($tokens as $phpToken) {
           $name = $phpToken->getTokenName();
           $text = $phpToken->text;
        }
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isFuncCallName($node, 'token_get_all')) {
            return null;
        }
        $this->refactorTokensVariable($node);
        return $this->createStaticCall('PhpToken', 'getAll', $node->args);
    }
    private function refactorTokensVariable(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : void
    {
        $assign = $funcCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$assign instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return;
        }
        $classMethodOrFunctionNode = $funcCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE) ?: $funcCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FUNCTION_NODE);
        if ($classMethodOrFunctionNode === null) {
            return;
        }
        // dummy approach, improve when needed
        $this->replaceGetNameOrGetValue($classMethodOrFunctionNode, $assign->var);
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function replaceGetNameOrGetValue(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, \_PhpScopere8e811afab72\PhpParser\Node\Expr $assignedExpr) : void
    {
        $tokensForeaches = $this->findForeachesOverTokenVariable($functionLike, $assignedExpr);
        foreach ($tokensForeaches as $tokensForeach) {
            $this->refactorTokenInForeach($tokensForeach);
        }
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     * @return Foreach_[]
     */
    private function findForeachesOverTokenVariable(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, \_PhpScopere8e811afab72\PhpParser\Node\Expr $assignedExpr) : array
    {
        return $this->betterNodeFinder->find((array) $functionLike->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($assignedExpr) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_) {
                return \false;
            }
            return $this->areNodesEqual($node->expr, $assignedExpr);
        });
    }
    private function refactorTokenInForeach(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_ $tokensForeach) : void
    {
        $singleToken = $tokensForeach->valueVar;
        if (!$singleToken instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return;
        }
        $this->traverseNodesWithCallable($tokensForeach, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($singleToken) {
            $this->tokenManipulator->refactorArrayToken([$node], $singleToken);
            $this->tokenManipulator->refactorNonArrayToken([$node], $singleToken);
            $this->tokenManipulator->refactorTokenIsKind([$node], $singleToken);
            $this->tokenManipulator->removeIsArray([$node], $singleToken);
            // drop if "If_" node not needed
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_ && $node->else !== null) {
                if (!$this->areNodesEqual($node->stmts, $node->else->stmts)) {
                    return null;
                }
                $this->unwrapStmts($node->stmts, $node);
                $this->removeNode($node);
            }
        });
    }
}
