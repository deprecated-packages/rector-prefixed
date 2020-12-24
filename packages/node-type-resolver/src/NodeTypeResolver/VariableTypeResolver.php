<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\VariableTypeResolverTest
 */
final class VariableTypeResolver implements \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var string[]
     */
    private const PARENT_NODE_ATTRIBUTES = [\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var TraitNodeScopeCollector
     */
    private $traitNodeScopeCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector $traitNodeScopeCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->traitNodeScopeCollector = $traitNodeScopeCollector;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $variableNode
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $variableNode) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $parentNode = $variableNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Param) {
            return $this->nodeTypeResolver->resolve($parentNode);
        }
        $variableName = $this->nodeNameResolver->getName($variableNode);
        if ($variableName === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $scopeType = $this->resolveTypesFromScope($variableNode, $variableName);
        if (!$scopeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return $scopeType;
        }
        // get from annotation
        $phpDocInfo = $variableNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            $phpDocInfo->getVarType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    /**
     * @required
     */
    public function autowireVariableTypeResolver(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    private function resolveTypesFromScope(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable, string $variableName) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $nodeScope = $this->resolveNodeScope($variable);
        if ($nodeScope === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        if (!$nodeScope->hasVariableType($variableName)->yes()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        // this → object type is easier to work with and consistent with the rest of the code
        return $nodeScope->getVariableType($variableName);
    }
    private function resolveNodeScope(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope
    {
        /** @var Scope|null $nodeScope */
        $nodeScope = $variable->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope !== null) {
            return $nodeScope;
        }
        // is node in trait
        $classLike = $variable->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_) {
            /** @var string $traitName */
            $traitName = $variable->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            $traitNodeScope = $this->traitNodeScopeCollector->getScopeForTraitAndNode($traitName, $variable);
            if ($traitNodeScope !== null) {
                return $traitNodeScope;
            }
        }
        return $this->resolveFromParentNodes($variable);
    }
    private function resolveFromParentNodes(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope
    {
        foreach (self::PARENT_NODE_ATTRIBUTES as $parentNodeAttribute) {
            $parentNode = $variable->getAttribute($parentNodeAttribute);
            if (!$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node) {
                continue;
            }
            $parentNodeScope = $parentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            if ($parentNodeScope === null) {
                continue;
            }
            return $parentNodeScope;
        }
        return null;
    }
}
