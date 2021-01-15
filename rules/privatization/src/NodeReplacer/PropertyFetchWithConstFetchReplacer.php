<?php

declare (strict_types=1);
namespace Rector\Privatization\NodeReplacer;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Privatization\Naming\ConstantNaming;
final class PropertyFetchWithConstFetchReplacer
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
     * @var PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    /**
     * @var ConstantNaming
     */
    private $constantNaming;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer, \Rector\Privatization\Naming\ConstantNaming $constantNaming)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
        $this->constantNaming = $constantNaming;
    }
    public function replace(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Stmt\Property $property) : void
    {
        $propertyProperty = $property->props[0];
        $propertyName = $this->nodeNameResolver->getName($property);
        $constantName = $this->constantNaming->createFromProperty($propertyProperty);
        $this->callableNodeTraverser->traverseNodesWithCallable($class, function (\PhpParser\Node $node) use($propertyName, $constantName) : ?ClassConstFetch {
            if (!$this->propertyFetchAnalyzer->isLocalPropertyFetch($node)) {
                return null;
            }
            /** @var PropertyFetch|StaticPropertyFetch $node */
            if (!$this->nodeNameResolver->isName($node->name, $propertyName)) {
                return null;
            }
            // replace with constant fetch
            // replace with constant fetch
            $name = $this->createSelf($node);
            return new \PhpParser\Node\Expr\ClassConstFetch($name, $constantName);
        });
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $propertyFetch
     */
    private function createSelf($propertyFetch) : \PhpParser\Node\Name
    {
        $name = new \PhpParser\Node\Name('self');
        $name->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $propertyFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME));
        return $name;
    }
}
