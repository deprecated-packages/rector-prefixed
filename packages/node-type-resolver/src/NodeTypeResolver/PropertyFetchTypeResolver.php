<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Trait_;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
use ReflectionProperty;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver\NameTypeResolverTest
 */
final class PropertyFetchTypeResolver implements \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocParser\BetterPhpDocParser $betterPhpDocParser, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector $traitNodeScopeCollector)
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
    public function autowirePropertyFetchTypeResolver(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch::class];
    }
    /**
     * @param PropertyFetch $node
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        // compensate 3rd party non-analysed property reflection
        $vendorPropertyType = $this->getVendorPropertyFetchType($node);
        if (!$vendorPropertyType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return $vendorPropertyType;
        }
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            $classNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if ($classNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Trait_) {
                /** @var string $traitName */
                $traitName = $classNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
                /** @var Scope|null $scope */
                $scope = $this->traitNodeScopeCollector->getScopeForTraitAndNode($traitName, $node);
            }
        }
        if ($scope === null) {
            $classNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            // fallback to class, since property fetches are not scoped by PHPStan
            if ($classNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike) {
                $scope = $classNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            }
            if ($scope === null) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
            }
        }
        return $scope->getType($node);
    }
    private function getVendorPropertyFetchType(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $varObjectType = $this->nodeTypeResolver->resolve($propertyFetch->var);
        if (!$varObjectType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $class = $this->parsedNodeCollector->findClass($varObjectType->getClassName());
        if ($class !== null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        // 3rd party code
        $propertyName = $this->nodeNameResolver->getName($propertyFetch->name);
        if ($propertyName === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        if (!\property_exists($varObjectType->getClassName(), $propertyName)) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        // property is used
        $reflectionProperty = new \ReflectionProperty($varObjectType->getClassName(), $propertyName);
        if (!$reflectionProperty->getDocComment()) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $phpDocNode = $this->betterPhpDocParser->parseString((string) $reflectionProperty->getDocComment());
        $varTagValues = $phpDocNode->getVarTagValues();
        if (!isset($varTagValues[0])) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $typeNode = $varTagValues[0]->type;
        if (!$typeNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        return $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Nop());
    }
}
