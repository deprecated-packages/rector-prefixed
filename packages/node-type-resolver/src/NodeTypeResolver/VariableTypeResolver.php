<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Trait_;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\VariableTypeResolverTest
 */
final class VariableTypeResolver implements \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var string[]
     */
    private const PARENT_NODE_ATTRIBUTES = [\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE];
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector $traitNodeScopeCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->traitNodeScopeCollector = $traitNodeScopeCollector;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $variableNode
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $variableNode) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $parentNode = $variableNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Param) {
            return $this->nodeTypeResolver->resolve($parentNode);
        }
        $variableName = $this->nodeNameResolver->getName($variableNode);
        if ($variableName === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $scopeType = $this->resolveTypesFromScope($variableNode, $variableName);
        if (!$scopeType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return $scopeType;
        }
        // get from annotation
        $phpDocInfo = $variableNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo instanceof \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            $phpDocInfo->getVarType();
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
    }
    /**
     * @required
     */
    public function autowireVariableTypeResolver(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    private function resolveTypesFromScope(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable, string $variableName) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $nodeScope = $this->resolveNodeScope($variable);
        if ($nodeScope === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        if (!$nodeScope->hasVariableType($variableName)->yes()) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        // this → object type is easier to work with and consistent with the rest of the code
        return $nodeScope->getVariableType($variableName);
    }
    private function resolveNodeScope(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope
    {
        /** @var Scope|null $nodeScope */
        $nodeScope = $variable->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope !== null) {
            return $nodeScope;
        }
        // is node in trait
        $classLike = $variable->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Trait_) {
            /** @var string $traitName */
            $traitName = $variable->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            $traitNodeScope = $this->traitNodeScopeCollector->getScopeForTraitAndNode($traitName, $variable);
            if ($traitNodeScope !== null) {
                return $traitNodeScope;
            }
        }
        return $this->resolveFromParentNodes($variable);
    }
    private function resolveFromParentNodes(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope
    {
        foreach (self::PARENT_NODE_ATTRIBUTES as $parentNodeAttribute) {
            $parentNode = $variable->getAttribute($parentNodeAttribute);
            if (!$parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node) {
                continue;
            }
            $parentNodeScope = $parentNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            if ($parentNodeScope === null) {
                continue;
            }
            return $parentNodeScope;
        }
        return null;
    }
}
