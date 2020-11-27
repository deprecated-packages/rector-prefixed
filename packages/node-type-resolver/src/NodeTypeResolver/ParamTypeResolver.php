<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Identifier;
use PhpParser\Node\Param;
use PhpParser\NodeTraverser;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\StaticTypeMapper\StaticTypeMapper;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ParamTypeResolver\ParamTypeResolverTest
 */
final class ParamTypeResolver implements \Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    public function __construct(\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @required
     */
    public function autowireParamTypeResolver(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\PhpParser\Node\Param::class];
    }
    /**
     * @param Param $node
     */
    public function resolve(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        $paramType = $this->resolveFromType($node);
        if (!$paramType instanceof \PHPStan\Type\MixedType) {
            return $paramType;
        }
        $firstVariableUseType = $this->resolveFromFirstVariableUse($node);
        if (!$firstVariableUseType instanceof \PHPStan\Type\MixedType) {
            return $firstVariableUseType;
        }
        return $this->resolveFromFunctionDocBlock($node);
    }
    private function resolveFromType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        if ($node->type !== null && !$node->type instanceof \PhpParser\Node\Identifier) {
            return $this->staticTypeMapper->mapPhpParserNodePHPStanType($node->type);
        }
        return new \PHPStan\Type\MixedType();
    }
    private function resolveFromFirstVariableUse(\PhpParser\Node\Param $param) : \PHPStan\Type\Type
    {
        $classMethod = $param->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod === null) {
            return new \PHPStan\Type\MixedType();
        }
        /** @var string $paramName */
        $paramName = $this->nodeNameResolver->getName($param);
        $paramStaticType = new \PHPStan\Type\MixedType();
        // special case for param inside method/function
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) use($paramName, &$paramStaticType) : ?int {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node, $paramName)) {
                return null;
            }
            $paramStaticType = $this->nodeTypeResolver->resolve($node);
            return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $paramStaticType;
    }
    private function resolveFromFunctionDocBlock(\PhpParser\Node\Param $param) : \PHPStan\Type\Type
    {
        $phpDocInfo = $this->getFunctionLikePhpDocInfo($param);
        if ($phpDocInfo === null) {
            return new \PHPStan\Type\MixedType();
        }
        /** @var string $paramName */
        $paramName = $this->nodeNameResolver->getName($param);
        return $phpDocInfo->getParamType($paramName);
    }
    private function getFunctionLikePhpDocInfo(\PhpParser\Node\Param $param) : ?\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $parentNode = $param->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \PhpParser\Node\FunctionLike) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return $parentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
    }
}
