<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\NodeManipulator;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch;
use _PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToRemoveCollector;
final class TokenManipulator
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodesToRemoveCollector
     */
    private $nodesToRemoveCollector;
    /**
     * @var Expr|null
     */
    private $assignedNameExpr;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->valueResolver = $valueResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
    }
    /**
     * @param Node[] $nodes
     */
    public function refactorArrayToken(array $nodes, \_PhpScopere8e811afab72\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->replaceTokenDimFetchZeroWithGetTokenName($nodes, $singleTokenExpr);
        // replace "$token[1]"; with "$token->value"
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : ?PropertyFetch {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
                return null;
            }
            if (!$this->isArrayDimFetchWithDimIntegerValue($node, 1)) {
                return null;
            }
            /** @var ArrayDimFetch $node */
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->var);
            if (!$tokenStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                return null;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch($node->var, 'text');
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function refactorNonArrayToken(array $nodes, \_PhpScopere8e811afab72\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        // replace "$content = $token;" → "$content = $token->text;"
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($singleTokenExpr) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($node->expr, $singleTokenExpr)) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->expr);
            if ($tokenStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                return null;
            }
            $node->expr = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch($singleTokenExpr, 'text');
        });
        // replace "$name = null;" → "$name = $token->getTokenName();"
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($singleTokenExpr) : ?Assign {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->expr);
            if ($tokenStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                return null;
            }
            if ($this->assignedNameExpr === null) {
                return null;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($node->var, $this->assignedNameExpr)) {
                return null;
            }
            if (!$this->valueResolver->isValue($node->expr, 'null')) {
                return null;
            }
            $node->expr = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($singleTokenExpr, 'getTokenName');
            return $node;
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function refactorTokenIsKind(array $nodes, \_PhpScopere8e811afab72\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($singleTokenExpr) : ?MethodCall {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical) {
                return null;
            }
            $arrayDimFetchAndConstFetch = $this->matchArrayDimFetchAndConstFetch($node);
            if ($arrayDimFetchAndConstFetch === null) {
                return null;
            }
            if (!$this->isArrayDimFetchWithDimIntegerValue($arrayDimFetchAndConstFetch->getArrayDimFetch(), 0)) {
                return null;
            }
            $arrayDimFetch = $arrayDimFetchAndConstFetch->getArrayDimFetch();
            $constFetch = $arrayDimFetchAndConstFetch->getConstFetch();
            if (!$this->betterStandardPrinter->areNodesEqual($arrayDimFetch->var, $singleTokenExpr)) {
                return null;
            }
            $constName = $this->nodeNameResolver->getName($constFetch);
            if ($constName === null) {
                return null;
            }
            if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::match($constName, '#^T_#')) {
                return null;
            }
            return $this->createIsTConstTypeMethodCall($arrayDimFetch, $arrayDimFetchAndConstFetch->getConstFetch());
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function removeIsArray(array $nodes, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $singleTokenVariable) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($singleTokenVariable) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node, 'is_array')) {
                return null;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($node->args[0]->value, $singleTokenVariable)) {
                return null;
            }
            if ($this->shouldSkipNodeRemovalForPartOfIf($node)) {
                return null;
            }
            // remove correct node
            $nodeToRemove = $this->matchParentNodeInCaseOfIdenticalTrue($node);
            $this->nodesToRemoveCollector->addNodeToRemove($nodeToRemove);
        });
    }
    /**
     * Replace $token[0] with $token->getTokenName() call
     *
     * @param Node[] $nodes
     */
    private function replaceTokenDimFetchZeroWithGetTokenName(array $nodes, \_PhpScopere8e811afab72\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($singleTokenExpr) : ?MethodCall {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node, 'token_name')) {
                return null;
            }
            $possibleTokenArray = $node->args[0]->value;
            if (!$possibleTokenArray instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($possibleTokenArray->var);
            if (!$tokenStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                return null;
            }
            if ($possibleTokenArray->dim === null) {
                return null;
            }
            if (!$this->valueResolver->isValue($possibleTokenArray->dim, 0)) {
                return null;
            }
            /** @var FuncCall $node */
            if (!$this->betterStandardPrinter->areNodesEqual($possibleTokenArray->var, $singleTokenExpr)) {
                return null;
            }
            // save token variable name for later
            $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                $this->assignedNameExpr = $parentNode->var;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($singleTokenExpr, 'getTokenName');
        });
    }
    private function isArrayDimFetchWithDimIntegerValue(\_PhpScopere8e811afab72\PhpParser\Node $node, int $value) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return \false;
        }
        if ($node->dim === null) {
            return \false;
        }
        return $this->valueResolver->isValue($node->dim, $value);
    }
    private function matchArrayDimFetchAndConstFetch(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScopere8e811afab72\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch
    {
        if ($identical->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch && $identical->right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch) {
            return new \_PhpScopere8e811afab72\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch($identical->left, $identical->right);
        }
        if ($identical->right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch && $identical->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch) {
            return new \_PhpScopere8e811afab72\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch($identical->right, $identical->left);
        }
        return null;
    }
    private function createIsTConstTypeMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch $constFetch) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($arrayDimFetch->var, 'is', [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($constFetch)]);
    }
    private function shouldSkipNodeRemovalForPartOfIf(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        $parentNode = $funcCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // cannot remove x from if(x)
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_ && $parentNode->cond === $funcCall) {
            return \true;
        }
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot) {
            $parentParentNode = $parentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_) {
                $parentParentNode->cond = $parentNode;
                return \true;
            }
        }
        return \false;
    }
    private function matchParentNodeInCaseOfIdenticalTrue(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScopere8e811afab72\PhpParser\Node
    {
        $parentNode = $funcCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical) {
            if ($parentNode->left === $funcCall && $this->isTrueConstant($parentNode->right)) {
                return $parentNode;
            }
            if ($parentNode->right === $funcCall && $this->isTrueConstant($parentNode->left)) {
                return $parentNode;
            }
        }
        return $funcCall;
    }
    private function isTrueConstant(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch) {
            return \false;
        }
        return $expr->name->toLowerString() === 'true';
    }
}
