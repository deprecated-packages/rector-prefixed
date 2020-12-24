<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ParamTypeResolver\ParamTypeResolverTest
 */
final class ParamTypeResolver implements \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @required
     */
    public function autowireParamTypeResolver(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Param::class];
    }
    /**
     * @param Param $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $paramType = $this->resolveFromParamType($node);
        if (!$paramType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return $paramType;
        }
        $firstVariableUseType = $this->resolveFromFirstVariableUse($node);
        if (!$firstVariableUseType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return $firstVariableUseType;
        }
        return $this->resolveFromFunctionDocBlock($node);
    }
    private function resolveFromParamType(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($param->type === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        if ($param->type instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
    }
    private function resolveFromFirstVariableUse(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $classMethod = $param->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        /** @var string $paramName */
        $paramName = $this->nodeNameResolver->getName($param);
        $paramStaticType = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        // special case for param inside method/function
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($paramName, &$paramStaticType) : ?int {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node, $paramName)) {
                return null;
            }
            $paramStaticType = $this->nodeTypeResolver->resolve($node);
            return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $paramStaticType;
    }
    private function resolveFromFunctionDocBlock(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $phpDocInfo = $this->getFunctionLikePhpDocInfo($param);
        if ($phpDocInfo === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        /** @var string $paramName */
        $paramName = $this->nodeNameResolver->getName($param);
        return $phpDocInfo->getParamType($paramName);
    }
    private function getFunctionLikePhpDocInfo(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : ?\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $parentNode = $param->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $parentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
    }
}
