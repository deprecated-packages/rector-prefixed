<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\CodeQuality\TypeResolver\ArrayDimFetchTypeResolver;
use _PhpScoperb75b35f52b74\Rector\Core\NodeAnalyzer\ClassNodeAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
final class LocalPropertyAnalyzer
{
    /**
     * @var string
     */
    private const LARAVEL_COLLECTION_CLASS = '_PhpScoperb75b35f52b74\\Illuminate\\Support\\Collection';
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\Rector\Core\NodeAnalyzer\ClassNodeAnalyzer $classNodeAnalyzer, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\CodeQuality\TypeResolver\ArrayDimFetchTypeResolver $arrayDimFetchTypeResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
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
    public function resolveFetchedPropertiesToTypesFromClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $fetchedLocalPropertyNameToTypes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$fetchedLocalPropertyNameToTypes) : ?int {
            // skip anonymous class scope
            if ($this->classNodeAnalyzer->isAnonymousClass($node)) {
                return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
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
    private function shouldSkipPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
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
    private function resolvePropertyFetchType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $parentNode = $propertyFetch->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // possible get type
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return $this->nodeTypeResolver->getStaticType($parentNode->expr);
        }
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch) {
            return $this->arrayDimFetchTypeResolver->resolve($parentNode);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
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
    private function shouldSkipForLaravelCollection(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
    {
        $staticCallOrClassMethod = $this->betterNodeFinder->findFirstAncestorInstancesOf($propertyFetch, [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class]);
        if (!$staticCallOrClassMethod instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        return $this->nodeNameResolver->isName($staticCallOrClassMethod->class, self::LARAVEL_COLLECTION_CLASS);
    }
    /**
     * Local property is actually not local one, but belongs to passed object
     * See https://ocramius.github.io/blog/accessing-private-php-class-members-without-reflection/
     */
    private function isPartOfClosureBind(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
    {
        $parentStaticCall = $this->betterNodeFinder->findFirstParentInstanceOf($propertyFetch, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class);
        if (!$parentStaticCall instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($parentStaticCall->class, 'Closure')) {
            return \true;
        }
        return $this->nodeNameResolver->isName($parentStaticCall->name, 'bind');
    }
    private function isPartOfClosureBindTo(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : bool
    {
        $parentMethodCall = $this->betterNodeFinder->findFirstParentInstanceOf($propertyFetch, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class);
        if (!$parentMethodCall instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$parentMethodCall->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure) {
            return \false;
        }
        return $this->nodeNameResolver->isName($parentMethodCall->name, 'bindTo');
    }
}
