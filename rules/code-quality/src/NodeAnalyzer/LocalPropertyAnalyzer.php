<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\CodeQuality\TypeResolver\ArrayDimFetchTypeResolver;
use _PhpScoper0a6b37af0871\Rector\Core\NodeAnalyzer\ClassNodeAnalyzer;
use _PhpScoper0a6b37af0871\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
final class LocalPropertyAnalyzer
{
    /**
     * @var string
     */
    private const LARAVEL_COLLECTION_CLASS = '_PhpScoper0a6b37af0871\\Illuminate\\Support\\Collection';
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var ClassNodeAnalyzer
     */
    private $classNodeAnalyzer;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var ArrayDimFetchTypeResolver
     */
    private $arrayDimFetchTypeResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a6b37af0871\Rector\Core\NodeAnalyzer\ClassNodeAnalyzer $classNodeAnalyzer, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a6b37af0871\Rector\CodeQuality\TypeResolver\ArrayDimFetchTypeResolver $arrayDimFetchTypeResolver, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper0a6b37af0871\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->classNodeAnalyzer = $classNodeAnalyzer;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->arrayDimFetchTypeResolver = $arrayDimFetchTypeResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
        $this->typeFactory = $typeFactory;
    }
    /**
     * @return array<string, Type>
     */
    public function resolveFetchedPropertiesToTypesFromClass(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $fetchedLocalPropertyNameToTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$fetchedLocalPropertyNameToTypes) : ?int {
            // skip anonymous class scope
            if ($this->classNodeAnalyzer->isAnonymousClass($node)) {
                return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
                return null;
            }
            if (!$this->propertyFetchAnalyzer->isLocalPropertyFetch($node)) {
                return null;
            }
            if ($this->shouldSkipPropertyFetch($node)) {
                return null;
            }
            $propertyName = $this->nodeNameResolver->getName($node->name);
            if ($propertyName === null) {
                return null;
            }
            $propertyFetchType = $this->resolvePropertyFetchType($node);
            $fetchedLocalPropertyNameToTypes[$propertyName][] = $propertyFetchType;
            return null;
        });
        return $this->normalizeToSingleType($fetchedLocalPropertyNameToTypes);
    }
    private function shouldSkipPropertyFetch(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
    {
        // special Laravel collection scope
        if ($this->shouldSkipForLaravelCollection($propertyFetch)) {
            return \true;
        }
        if ($this->isPartOfClosureBind($propertyFetch)) {
            return \true;
        }
        return $this->isPartOfClosureBindTo($propertyFetch);
    }
    private function resolvePropertyFetchType(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $parentNode = $propertyFetch->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // possible get type
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
            return $this->nodeTypeResolver->getStaticType($parentNode->expr);
        }
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
            return $this->arrayDimFetchTypeResolver->resolve($parentNode);
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
    }
    /**
     * @param array<string, Type[]> $propertyNameToTypes
     * @return array<string, Type>
     */
    private function normalizeToSingleType(array $propertyNameToTypes) : array
    {
        // normalize types to union
        $propertyNameToType = [];
        foreach ($propertyNameToTypes as $name => $types) {
            $propertyNameToType[$name] = $this->typeFactory->createMixedPassedOrUnionType($types);
        }
        return $propertyNameToType;
    }
    private function shouldSkipForLaravelCollection(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
    {
        $staticCallOrClassMethod = $this->betterNodeFinder->findFirstAncestorInstancesOf($propertyFetch, [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class]);
        if (!$staticCallOrClassMethod instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        return $this->nodeNameResolver->isName($staticCallOrClassMethod->class, self::LARAVEL_COLLECTION_CLASS);
    }
    /**
     * Local property is actually not local one, but belongs to passed object
     * See https://ocramius.github.io/blog/accessing-private-php-class-members-without-reflection/
     */
    private function isPartOfClosureBind(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
    {
        $parentStaticCall = $this->betterNodeFinder->findFirstParentInstanceOf($propertyFetch, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class);
        if (!$parentStaticCall instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($parentStaticCall->class, 'Closure')) {
            return \true;
        }
        return $this->nodeNameResolver->isName($parentStaticCall->name, 'bind');
    }
    private function isPartOfClosureBindTo(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
    {
        $parentMethodCall = $this->betterNodeFinder->findFirstParentInstanceOf($propertyFetch, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class);
        if (!$parentMethodCall instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$parentMethodCall->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure) {
            return \false;
        }
        return $this->nodeNameResolver->isName($parentMethodCall->name, 'bindTo');
    }
}
