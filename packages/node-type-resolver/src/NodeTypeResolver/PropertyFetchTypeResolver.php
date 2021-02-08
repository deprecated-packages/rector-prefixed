<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\Property;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\PropertyProperty;
use PhpParser\Node\Stmt\Trait_;
use PhpParser\Node\VarLikeIdentifier;
use PhpParser\Parser;
use PHPStan\Analyser\Scope;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector;
use Rector\StaticTypeMapper\StaticTypeMapper;
use RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\PropertyFetchTypeResolverTest
 */
final class PropertyFetchTypeResolver implements \Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
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
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var TraitNodeScopeCollector
     */
    private $traitNodeScopeCollector;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var Parser
     */
    private $parser;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector $traitNodeScopeCollector, \RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \PhpParser\Parser $parser)
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->traitNodeScopeCollector = $traitNodeScopeCollector;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->smartFileSystem = $smartFileSystem;
        $this->parser = $parser;
    }
    /**
     * @required
     */
    public function autowirePropertyFetchTypeResolver(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\PhpParser\Node\Expr\PropertyFetch::class];
    }
    /**
     * @param PropertyFetch $node
     */
    public function resolve(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        // compensate 3rd party non-analysed property reflection
        $vendorPropertyType = $this->getVendorPropertyFetchType($node);
        if (!$vendorPropertyType instanceof \PHPStan\Type\MixedType) {
            return $vendorPropertyType;
        }
        /** @var Scope|null $scope */
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            $classNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if ($classNode instanceof \PhpParser\Node\Stmt\Trait_) {
                /** @var string $traitName */
                $traitName = $classNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
                $scope = $this->traitNodeScopeCollector->getScopeForTraitAndNode($traitName, $node);
            }
        }
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            $classNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            // fallback to class, since property fetches are not scoped by PHPStan
            if ($classNode instanceof \PhpParser\Node\Stmt\ClassLike) {
                $scope = $classNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            }
            if (!$scope instanceof \PHPStan\Analyser\Scope) {
                return new \PHPStan\Type\MixedType();
            }
        }
        return $scope->getType($node);
    }
    private function getVendorPropertyFetchType(\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \PHPStan\Type\Type
    {
        $varObjectType = $this->nodeTypeResolver->resolve($propertyFetch->var);
        if (!$varObjectType instanceof \PHPStan\Type\TypeWithClassName) {
            return new \PHPStan\Type\MixedType();
        }
        $class = $this->parsedNodeCollector->findClass($varObjectType->getClassName());
        if ($class !== null) {
            return new \PHPStan\Type\MixedType();
        }
        // 3rd party code
        $propertyName = $this->nodeNameResolver->getName($propertyFetch->name);
        if ($propertyName === null) {
            return new \PHPStan\Type\MixedType();
        }
        if (!\property_exists($varObjectType->getClassName(), $propertyName)) {
            return new \PHPStan\Type\MixedType();
        }
        $phpDocInfo = $propertyFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo && $varObjectType instanceof \PHPStan\Type\ObjectType) {
            return $this->getPropertyPropertyResolution($varObjectType, $propertyName);
        }
        return $this->getTypeFromPhpDocInfo($phpDocInfo);
    }
    private function getPropertyPropertyResolution(\PHPStan\Type\ObjectType $varObjectType, string $propertyName) : \PHPStan\Type\Type
    {
        $classReflection = $varObjectType->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return $varObjectType;
        }
        if ($classReflection->isBuiltIn()) {
            return $varObjectType;
        }
        $nodes = $this->parser->parse($this->smartFileSystem->readFile((string) $classReflection->getFileName()));
        $propertyProperty = $this->betterNodeFinder->findFirst($nodes, function (\PhpParser\Node $node) use($propertyName) : bool {
            if (!$node instanceof \PhpParser\Node\Stmt\PropertyProperty) {
                return \false;
            }
            if (!$node->name instanceof \PhpParser\Node\VarLikeIdentifier) {
                return \false;
            }
            return $node->name->toString() === $propertyName;
        });
        if ($propertyProperty instanceof \PhpParser\Node\Stmt\PropertyProperty) {
            return $this->nodeTypeResolver->resolve($propertyProperty);
        }
        return new \PHPStan\Type\MixedType();
    }
    private function getTypeFromPhpDocInfo(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : \PHPStan\Type\Type
    {
        $tagValueNode = $phpDocInfo->getVarTagValueNode();
        if (!$tagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode) {
            return new \PHPStan\Type\MixedType();
        }
        $typeNode = $tagValueNode->type;
        if (!$typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\TypeNode) {
            return new \PHPStan\Type\MixedType();
        }
        return $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($typeNode, new \PhpParser\Node\Stmt\Nop());
    }
}
