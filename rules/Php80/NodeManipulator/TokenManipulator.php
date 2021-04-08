<?php

declare (strict_types=1);
namespace Rector\Php80\NodeManipulator;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\If_;
use PHPStan\Type\ArrayType;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch;
use Rector\PostRector\Collector\NodesToRemoveCollector;
use RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class TokenManipulator
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var NodeComparator
     */
    private $nodeComparator;
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
    public function __construct(\RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->valueResolver = $valueResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->nodeComparator = $nodeComparator;
    }
    /**
     * @param Node[] $nodes
     */
    public function refactorArrayToken(array $nodes, \PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->replaceTokenDimFetchZeroWithGetTokenName($nodes, $singleTokenExpr);
        // replace "$token[1]"; with "$token->value"
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($nodes, function (\PhpParser\Node $node) : ?PropertyFetch {
            if (!$node instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
                return null;
            }
            if (!$this->isArrayDimFetchWithDimIntegerValue($node, 1)) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->var);
            if (!$tokenStaticType instanceof \PHPStan\Type\ArrayType) {
                return null;
            }
            return new \PhpParser\Node\Expr\PropertyFetch($node->var, 'text');
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function refactorNonArrayToken(array $nodes, \PhpParser\Node\Expr $singleTokenExpr) : void
    {
        // replace "$content = $token;" → "$content = $token->text;"
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($nodes, function (\PhpParser\Node $node) use($singleTokenExpr) {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->nodeComparator->areNodesEqual($node->expr, $singleTokenExpr)) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->expr);
            if ($tokenStaticType instanceof \PHPStan\Type\ArrayType) {
                return null;
            }
            $node->expr = new \PhpParser\Node\Expr\PropertyFetch($singleTokenExpr, 'text');
        });
        // replace "$name = null;" → "$name = $token->getTokenName();"
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($nodes, function (\PhpParser\Node $node) use($singleTokenExpr) : ?Assign {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($node->expr);
            if ($tokenStaticType instanceof \PHPStan\Type\ArrayType) {
                return null;
            }
            if ($this->assignedNameExpr === null) {
                return null;
            }
            if (!$this->nodeComparator->areNodesEqual($node->var, $this->assignedNameExpr)) {
                return null;
            }
            if (!$this->valueResolver->isValue($node->expr, 'null')) {
                return null;
            }
            $node->expr = new \PhpParser\Node\Expr\MethodCall($singleTokenExpr, 'getTokenName');
            return $node;
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function refactorTokenIsKind(array $nodes, \PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($nodes, function (\PhpParser\Node $node) use($singleTokenExpr) : ?MethodCall {
            if (!$node instanceof \PhpParser\Node\Expr\BinaryOp\Identical) {
                return null;
            }
            $arrayDimFetchAndConstFetch = $this->matchArrayDimFetchAndConstFetch($node);
            if (!$arrayDimFetchAndConstFetch instanceof \Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch) {
                return null;
            }
            if (!$this->isArrayDimFetchWithDimIntegerValue($arrayDimFetchAndConstFetch->getArrayDimFetch(), 0)) {
                return null;
            }
            $arrayDimFetch = $arrayDimFetchAndConstFetch->getArrayDimFetch();
            $constFetch = $arrayDimFetchAndConstFetch->getConstFetch();
            if (!$this->nodeComparator->areNodesEqual($arrayDimFetch->var, $singleTokenExpr)) {
                return null;
            }
            $constName = $this->nodeNameResolver->getName($constFetch);
            if ($constName === null) {
                return null;
            }
            if (!\RectorPrefix20210408\Nette\Utils\Strings::match($constName, '#^T_#')) {
                return null;
            }
            return $this->createIsTConstTypeMethodCall($arrayDimFetch, $arrayDimFetchAndConstFetch->getConstFetch());
        });
    }
    /**
     * @param Node[] $nodes
     */
    public function removeIsArray(array $nodes, \PhpParser\Node\Expr\Variable $singleTokenVariable) : void
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($nodes, function (\PhpParser\Node $node) use($singleTokenVariable) {
            if (!$node instanceof \PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node, 'is_array')) {
                return null;
            }
            if (!$this->nodeComparator->areNodesEqual($node->args[0]->value, $singleTokenVariable)) {
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
    private function replaceTokenDimFetchZeroWithGetTokenName(array $nodes, \PhpParser\Node\Expr $singleTokenExpr) : void
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($nodes, function (\PhpParser\Node $node) use($singleTokenExpr) : ?MethodCall {
            if (!$node instanceof \PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node, 'token_name')) {
                return null;
            }
            $possibleTokenArray = $node->args[0]->value;
            if (!$possibleTokenArray instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
                return null;
            }
            $tokenStaticType = $this->nodeTypeResolver->getStaticType($possibleTokenArray->var);
            if (!$tokenStaticType instanceof \PHPStan\Type\ArrayType) {
                return null;
            }
            if ($possibleTokenArray->dim === null) {
                return null;
            }
            if (!$this->valueResolver->isValue($possibleTokenArray->dim, 0)) {
                return null;
            }
            if (!$this->nodeComparator->areNodesEqual($possibleTokenArray->var, $singleTokenExpr)) {
                return null;
            }
            // save token variable name for later
            $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \PhpParser\Node\Expr\Assign) {
                $this->assignedNameExpr = $parentNode->var;
            }
            return new \PhpParser\Node\Expr\MethodCall($singleTokenExpr, 'getTokenName');
        });
    }
    private function isArrayDimFetchWithDimIntegerValue(\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, int $value) : bool
    {
        if ($arrayDimFetch->dim === null) {
            return \false;
        }
        return $this->valueResolver->isValue($arrayDimFetch->dim, $value);
    }
    private function matchArrayDimFetchAndConstFetch(\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch
    {
        if ($identical->left instanceof \PhpParser\Node\Expr\ArrayDimFetch && $identical->right instanceof \PhpParser\Node\Expr\ConstFetch) {
            return new \Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch($identical->left, $identical->right);
        }
        if (!$identical->right instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return null;
        }
        if (!$identical->left instanceof \PhpParser\Node\Expr\ConstFetch) {
            return null;
        }
        return new \Rector\Php80\ValueObject\ArrayDimFetchAndConstFetch($identical->right, $identical->left);
    }
    private function createIsTConstTypeMethodCall(\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \PhpParser\Node\Expr\ConstFetch $constFetch) : \PhpParser\Node\Expr\MethodCall
    {
        return new \PhpParser\Node\Expr\MethodCall($arrayDimFetch->var, 'is', [new \PhpParser\Node\Arg($constFetch)]);
    }
    private function shouldSkipNodeRemovalForPartOfIf(\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        $parentNode = $funcCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // cannot remove x from if(x)
        if ($parentNode instanceof \PhpParser\Node\Stmt\If_ && $parentNode->cond === $funcCall) {
            return \true;
        }
        if ($parentNode instanceof \PhpParser\Node\Expr\BooleanNot) {
            $parentParentNode = $parentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParentNode instanceof \PhpParser\Node\Stmt\If_) {
                $parentParentNode->cond = $parentNode;
                return \true;
            }
        }
        return \false;
    }
    private function matchParentNodeInCaseOfIdenticalTrue(\PhpParser\Node\Expr\FuncCall $funcCall) : \PhpParser\Node\Expr
    {
        $parentNode = $funcCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \PhpParser\Node\Expr\BinaryOp\Identical) {
            $isRightValueTrue = $this->valueResolver->isValue($parentNode->right, \true);
            if ($parentNode->left === $funcCall && $isRightValueTrue) {
                return $parentNode;
            }
            $isLeftValueTrue = $this->valueResolver->isValue($parentNode->left, \true);
            if ($parentNode->right === $funcCall && $isLeftValueTrue) {
                return $parentNode;
            }
        }
        return $funcCall;
    }
}
