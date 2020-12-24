<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php80\NodeManipulator;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a6b37af0871\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch;
use _PhpScoper0a6b37af0871\Rector\PostRector\Collector\NodesToRemoveCollector;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper0a6b37af0871\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
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
    public function refactorArrayToken(array $nodes, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->replaceTokenDimFetchZeroWithGetTokenName($nodes, $singleTokenExpr);
        // replace "$token[1]"; with "$token->value"
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?PropertyFetch {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
                return null;
            }
            if (!$this->isArrayDimFetchWithDimIntegerValue($node, 1)) {
                return null;
            }
            /** @var ArrayDimFetch $node */
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->var);
            if (!$tokenStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
                return null;
            }
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch($node->var, 'text');
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function refactorNonArrayToken(array $nodes, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        // replace "$content = $token;" → "$content = $token->text;"
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($singleTokenExpr) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($node->expr, $singleTokenExpr)) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->expr);
            if ($tokenStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
                return null;
            }
            $node->expr = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch($singleTokenExpr, 'text');
        });
        // replace "$name = null;" → "$name = $token->getTokenName();"
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($singleTokenExpr) : ?Assign {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->expr);
            if ($tokenStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
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
            $node->expr = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($singleTokenExpr, 'getTokenName');
            return $node;
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function refactorTokenIsKind(array $nodes, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($singleTokenExpr) : ?MethodCall {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical) {
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
            if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($constName, '#^T_#')) {
                return null;
            }
            return $this->createIsTConstTypeMethodCall($arrayDimFetch, $arrayDimFetchAndConstFetch->getConstFetch());
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function removeIsArray(array $nodes, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $singleTokenVariable) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($singleTokenVariable) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
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
    private function replaceTokenDimFetchZeroWithGetTokenName(array $nodes, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($singleTokenExpr) : ?MethodCall {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node, 'token_name')) {
                return null;
            }
            $possibleTokenArray = $node->args[0]->value;
            if (!$possibleTokenArray instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($possibleTokenArray->var);
            if (!$tokenStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
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
            $parentNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                $this->assignedNameExpr = $parentNode->var;
            }
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($singleTokenExpr, 'getTokenName');
        });
    }
    private function isArrayDimFetchWithDimIntegerValue(\_PhpScoper0a6b37af0871\PhpParser\Node $node, int $value) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
            return \false;
        }
        if ($node->dim === null) {
            return \false;
        }
        return $this->valueResolver->isValue($node->dim, $value);
    }
    private function matchArrayDimFetchAndConstFetch(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch
    {
        if ($identical->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch && $identical->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch) {
            return new \_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch($identical->left, $identical->right);
        }
        if ($identical->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch && $identical->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch) {
            return new \_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch($identical->right, $identical->left);
        }
        return null;
    }
    private function createIsTConstTypeMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch $constFetch) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall
    {
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($arrayDimFetch->var, 'is', [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($constFetch)]);
    }
    private function shouldSkipNodeRemovalForPartOfIf(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        $parentNode = $funcCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // cannot remove x from if(x)
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_ && $parentNode->cond === $funcCall) {
            return \true;
        }
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot) {
            $parentParentNode = $parentNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_) {
                $parentParentNode->cond = $parentNode;
                return \true;
            }
        }
        return \false;
    }
    private function matchParentNodeInCaseOfIdenticalTrue(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $parentNode = $funcCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical) {
            if ($parentNode->left === $funcCall && $this->isTrueConstant($parentNode->right)) {
                return $parentNode;
            }
            if ($parentNode->right === $funcCall && $this->isTrueConstant($parentNode->left)) {
                return $parentNode;
            }
        }
        return $funcCall;
    }
    private function isTrueConstant(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch) {
            return \false;
        }
        return $expr->name->toLowerString() === 'true';
    }
}
