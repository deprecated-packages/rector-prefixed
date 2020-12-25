<?php

declare (strict_types=1);
namespace Rector\NodeCollector\NodeCollector;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;
/**
 * All parsed nodes grouped type
 */
final class ParsedPropertyFetchNodeCollector
{
    /**
     * @var PropertyFetch[][][]
     */
    private $propertyFetchesByTypeAndName = [];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * To prevent circular reference
     * @required
     */
    public function autowireParsedPropertyFetchNodeCollector(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function collect(\PhpParser\Node $node) : void
    {
        if (!$node instanceof \PhpParser\Node\Expr\PropertyFetch && !$node instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
            return;
        }
        $propertyType = $this->resolvePropertyCallerType($node);
        // make sure name is valid
        if ($node->name instanceof \PhpParser\Node\Expr\StaticCall) {
            return;
        }
        if ($node->name instanceof \PhpParser\Node\Expr\MethodCall) {
            return;
        }
        $propertyName = $this->nodeNameResolver->getName($node->name);
        if ($propertyName === null) {
            return;
        }
        $this->addPropertyFetchWithTypeAndName($propertyType, $node, $propertyName);
    }
    /**
     * @return PropertyFetch[]
     */
    public function findPropertyFetchesByTypeAndName(string $className, string $propertyName) : array
    {
        return $this->propertyFetchesByTypeAndName[$className][$propertyName] ?? [];
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $node
     */
    private function resolvePropertyCallerType(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        if ($node instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return $this->nodeTypeResolver->getStaticType($node->var);
        }
        return $this->nodeTypeResolver->getStaticType($node->class);
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $propertyFetchNode
     */
    private function addPropertyFetchWithTypeAndName(\PHPStan\Type\Type $propertyType, \PhpParser\Node $propertyFetchNode, string $propertyName) : void
    {
        if ($propertyType instanceof \PHPStan\Type\TypeWithClassName) {
            $this->propertyFetchesByTypeAndName[$propertyType->getClassName()][$propertyName][] = $propertyFetchNode;
        }
        if ($propertyType instanceof \PHPStan\Type\UnionType) {
            foreach ($propertyType->getTypes() as $unionedType) {
                $this->addPropertyFetchWithTypeAndName($unionedType, $propertyFetchNode, $propertyName);
            }
        }
    }
}
