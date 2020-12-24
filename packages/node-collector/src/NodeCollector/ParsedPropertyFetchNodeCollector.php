<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * To prevent circular reference
     * @required
     */
    public function autowireParsedPropertyFetchNodeCollector(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function collect(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) {
            return;
        }
        $propertyType = $this->resolvePropertyCallerType($node);
        // make sure name is valid
        if ($node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall || $node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
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
    private function resolvePropertyCallerType(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return $this->nodeTypeResolver->getStaticType($node->var);
        }
        return $this->nodeTypeResolver->getStaticType($node->class);
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $propertyFetchNode
     */
    private function addPropertyFetchWithTypeAndName(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $propertyType, \_PhpScoperb75b35f52b74\PhpParser\Node $propertyFetchNode, string $propertyName) : void
    {
        if ($propertyType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            $this->propertyFetchesByTypeAndName[$propertyType->getClassName()][$propertyName][] = $propertyFetchNode;
        }
        if ($propertyType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            foreach ($propertyType->getTypes() as $unionedType) {
                $this->addPropertyFetchWithTypeAndName($unionedType, $propertyFetchNode, $propertyName);
            }
        }
    }
}
