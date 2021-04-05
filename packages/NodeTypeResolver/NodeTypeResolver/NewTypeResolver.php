<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class NewTypeResolver implements \Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeClasses() : array
    {
        return [\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function resolve(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        if ($node->class instanceof \PhpParser\Node\Name) {
            $className = $this->nodeNameResolver->getName($node->class);
            return new \PHPStan\Type\ObjectType($className);
        }
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            // new node probably
            return new \PHPStan\Type\MixedType();
        }
        return $scope->getType($node);
    }
}
