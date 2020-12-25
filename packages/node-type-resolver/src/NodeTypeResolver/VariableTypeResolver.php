<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Analyser\Scope;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\VariableTypeResolverTest
 */
final class VariableTypeResolver implements \Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var string[]
     */
    private const PARENT_NODE_ATTRIBUTES = [\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, \Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE];
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
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector $traitNodeScopeCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->traitNodeScopeCollector = $traitNodeScopeCollector;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $variableNode
     */
    public function resolve(\PhpParser\Node $variableNode) : \PHPStan\Type\Type
    {
        $parentNode = $variableNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \PhpParser\Node\Param) {
            return $this->nodeTypeResolver->resolve($parentNode);
        }
        $variableName = $this->nodeNameResolver->getName($variableNode);
        if ($variableName === null) {
            return new \PHPStan\Type\MixedType();
        }
        $scopeType = $this->resolveTypesFromScope($variableNode, $variableName);
        if (!$scopeType instanceof \PHPStan\Type\MixedType) {
            return $scopeType;
        }
        // get from annotation
        $phpDocInfo = $variableNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            $phpDocInfo->getVarType();
        }
        return new \PHPStan\Type\MixedType();
    }
    /**
     * @required
     */
    public function autowireVariableTypeResolver(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    private function resolveTypesFromScope(\PhpParser\Node\Expr\Variable $variable, string $variableName) : \PHPStan\Type\Type
    {
        $nodeScope = $this->resolveNodeScope($variable);
        if ($nodeScope === null) {
            return new \PHPStan\Type\MixedType();
        }
        if (!$nodeScope->hasVariableType($variableName)->yes()) {
            return new \PHPStan\Type\MixedType();
        }
        // this → object type is easier to work with and consistent with the rest of the code
        return $nodeScope->getVariableType($variableName);
    }
    private function resolveNodeScope(\PhpParser\Node\Expr\Variable $variable) : ?\PHPStan\Analyser\Scope
    {
        /** @var Scope|null $nodeScope */
        $nodeScope = $variable->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope !== null) {
            return $nodeScope;
        }
        // is node in trait
        $classLike = $variable->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike instanceof \PhpParser\Node\Stmt\Trait_) {
            /** @var string $traitName */
            $traitName = $variable->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            $traitNodeScope = $this->traitNodeScopeCollector->getScopeForTraitAndNode($traitName, $variable);
            if ($traitNodeScope !== null) {
                return $traitNodeScope;
            }
        }
        return $this->resolveFromParentNodes($variable);
    }
    private function resolveFromParentNodes(\PhpParser\Node\Expr\Variable $variable) : ?\PHPStan\Analyser\Scope
    {
        foreach (self::PARENT_NODE_ATTRIBUTES as $parentNodeAttribute) {
            $parentNode = $variable->getAttribute($parentNodeAttribute);
            if (!$parentNode instanceof \PhpParser\Node) {
                continue;
            }
            $parentNodeScope = $parentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            if ($parentNodeScope === null) {
                continue;
            }
            return $parentNodeScope;
        }
        return null;
    }
}
