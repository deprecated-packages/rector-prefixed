<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\Type;
use Rector\Core\NodeAnalyzer\ClassAnalyzer;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\StaticTypeMapper\TypeFactory\UnionTypeFactory;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class NewTypeResolver implements \Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ClassAnalyzer
     */
    private $classAnalyzer;
    /**
     * @var UnionTypeFactory
     */
    private $unionTypeFactory;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\NodeAnalyzer\ClassAnalyzer $classAnalyzer, \Rector\StaticTypeMapper\TypeFactory\UnionTypeFactory $unionTypeFactory)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classAnalyzer = $classAnalyzer;
        $this->unionTypeFactory = $unionTypeFactory;
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
            if (!\in_array($className, ['self', 'parent'], \true)) {
                return new \PHPStan\Type\ObjectType($className);
            }
        }
        $isAnonymousClass = $this->classAnalyzer->isAnonymousClass($node->class);
        if ($isAnonymousClass) {
            return $this->resolveAnonymousClassType($node);
        }
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            // new node probably
            return new \PHPStan\Type\MixedType();
        }
        return $scope->getType($node);
    }
    private function resolveAnonymousClassType(\PhpParser\Node\Expr\New_ $new) : \PHPStan\Type\ObjectWithoutClassType
    {
        if (!$new->class instanceof \PhpParser\Node\Stmt\Class_) {
            return new \PHPStan\Type\ObjectWithoutClassType();
        }
        $types = [];
        /** @var Class_ $class */
        $class = $new->class;
        if ($class->extends !== null) {
            $parentClass = (string) $class->extends;
            $types[] = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($parentClass);
        }
        foreach ($class->implements as $implement) {
            $parentClass = (string) $implement;
            $types[] = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($parentClass);
        }
        if (\count($types) > 1) {
            $unionType = $this->unionTypeFactory->createUnionObjectType($types);
            return new \PHPStan\Type\ObjectWithoutClassType($unionType);
        }
        if (\count($types) === 1) {
            return new \PHPStan\Type\ObjectWithoutClassType($types[0]);
        }
        return new \PHPStan\Type\ObjectWithoutClassType();
    }
}
