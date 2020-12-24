<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php80\NodeManipulator;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToRemoveCollector;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
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
    public function refactorArrayToken(array $nodes, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->replaceTokenDimFetchZeroWithGetTokenName($nodes, $singleTokenExpr);
        // replace "$token[1]"; with "$token->value"
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?PropertyFetch {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch) {
                return null;
            }
            if (!$this->isArrayDimFetchWithDimIntegerValue($node, 1)) {
                return null;
            }
            /** @var ArrayDimFetch $node */
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->var);
            if (!$tokenStaticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
                return null;
            }
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch($node->var, 'text');
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function refactorNonArrayToken(array $nodes, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        // replace "$content = $token;" → "$content = $token->text;"
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($singleTokenExpr) {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($node->expr, $singleTokenExpr)) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->expr);
            if ($tokenStaticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
                return null;
            }
            $node->expr = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch($singleTokenExpr, 'text');
        });
        // replace "$name = null;" → "$name = $token->getTokenName();"
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($singleTokenExpr) : ?Assign {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->expr);
            if ($tokenStaticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
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
            $node->expr = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($singleTokenExpr, 'getTokenName');
            return $node;
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function refactorTokenIsKind(array $nodes, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($singleTokenExpr) : ?MethodCall {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical) {
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
            if (!\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::match($constName, '#^T_#')) {
                return null;
            }
            return $this->createIsTConstTypeMethodCall($arrayDimFetch, $arrayDimFetchAndConstFetch->getConstFetch());
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function removeIsArray(array $nodes, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $singleTokenVariable) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($singleTokenVariable) {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall) {
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
    private function replaceTokenDimFetchZeroWithGetTokenName(array $nodes, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($singleTokenExpr) : ?MethodCall {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node, 'token_name')) {
                return null;
            }
            $possibleTokenArray = $node->args[0]->value;
            if (!$possibleTokenArray instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($possibleTokenArray->var);
            if (!$tokenStaticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
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
            $parentNode = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
                $this->assignedNameExpr = $parentNode->var;
            }
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($singleTokenExpr, 'getTokenName');
        });
    }
    private function isArrayDimFetchWithDimIntegerValue(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, int $value) : bool
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch) {
            return \false;
        }
        if ($node->dim === null) {
            return \false;
        }
        return $this->valueResolver->isValue($node->dim, $value);
    }
    private function matchArrayDimFetchAndConstFetch(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch
    {
        if ($identical->left instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch && $identical->right instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch) {
            return new \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch($identical->left, $identical->right);
        }
        if ($identical->right instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch && $identical->left instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch) {
            return new \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch($identical->right, $identical->left);
        }
        return null;
    }
    private function createIsTConstTypeMethodCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch $constFetch) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall
    {
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($arrayDimFetch->var, 'is', [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($constFetch)]);
    }
    private function shouldSkipNodeRemovalForPartOfIf(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        $parentNode = $funcCall->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // cannot remove x from if(x)
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_ && $parentNode->cond === $funcCall) {
            return \true;
        }
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot) {
            $parentParentNode = $parentNode->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_) {
                $parentParentNode->cond = $parentNode;
                return \true;
            }
        }
        return \false;
    }
    private function matchParentNodeInCaseOfIdenticalTrue(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $parentNode = $funcCall->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical) {
            if ($parentNode->left === $funcCall && $this->isTrueConstant($parentNode->right)) {
                return $parentNode;
            }
            if ($parentNode->right === $funcCall && $this->isTrueConstant($parentNode->left)) {
                return $parentNode;
            }
        }
        return $funcCall;
    }
    private function isTrueConstant(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch) {
            return \false;
        }
        return $expr->name->toLowerString() === 'true';
    }
}
