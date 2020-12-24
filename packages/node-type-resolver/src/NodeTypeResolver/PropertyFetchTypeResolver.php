<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
use ReflectionProperty;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver\NameTypeResolverTest
 */
final class PropertyFetchTypeResolver implements \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterPhpDocParser
     */
    private $betterPhpDocParser;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var TraitNodeScopeCollector
     */
    private $traitNodeScopeCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser $betterPhpDocParser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector $traitNodeScopeCollector)
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterPhpDocParser = $betterPhpDocParser;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->traitNodeScopeCollector = $traitNodeScopeCollector;
    }
    /**
     * @required
     */
    public function autowirePropertyFetchTypeResolver(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch::class];
    }
    /**
     * @param PropertyFetch $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        // compensate 3rd party non-analysed property reflection
        $vendorPropertyType = $this->getVendorPropertyFetchType($node);
        if (!$vendorPropertyType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return $vendorPropertyType;
        }
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            $classNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if ($classNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_) {
                /** @var string $traitName */
                $traitName = $classNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
                /** @var Scope|null $scope */
                $scope = $this->traitNodeScopeCollector->getScopeForTraitAndNode($traitName, $node);
            }
        }
        if ($scope === null) {
            $classNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            // fallback to class, since property fetches are not scoped by PHPStan
            if ($classNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
                $scope = $classNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            }
            if ($scope === null) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
            }
        }
        return $scope->getType($node);
    }
    private function getVendorPropertyFetchType(\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $varObjectType = $this->nodeTypeResolver->resolve($propertyFetch->var);
        if (!$varObjectType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $class = $this->parsedNodeCollector->findClass($varObjectType->getClassName());
        if ($class !== null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        // 3rd party code
        $propertyName = $this->nodeNameResolver->getName($propertyFetch->name);
        if ($propertyName === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        if (!\property_exists($varObjectType->getClassName(), $propertyName)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        // property is used
        $reflectionProperty = new \ReflectionProperty($varObjectType->getClassName(), $propertyName);
        if (!$reflectionProperty->getDocComment()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $phpDocNode = $this->betterPhpDocParser->parseString((string) $reflectionProperty->getDocComment());
        $varTagValues = $phpDocNode->getVarTagValues();
        if (!isset($varTagValues[0])) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $typeNode = $varTagValues[0]->type;
        if (!$typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Nop());
    }
}
