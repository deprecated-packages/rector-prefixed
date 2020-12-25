<?php

declare (strict_types=1);
namespace Rector\RemovingStatic;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\ObjectType;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class StaticTypesInClassResolver
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param string[] $types
     * @return ObjectType[]
     */
    public function collectStaticCallTypeInClass(\PhpParser\Node\Stmt\Class_ $class, array $types) : array
    {
        $staticTypesInClass = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\PhpParser\Node $class) use($types, &$staticTypesInClass) {
            if (!$class instanceof \PhpParser\Node\Expr\StaticCall) {
                return null;
            }
            foreach ($types as $type) {
                if ($this->nodeTypeResolver->isObjectType($class->class, $type)) {
                    $staticTypesInClass[] = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($type);
                }
            }
            return null;
        });
        return $staticTypesInClass;
    }
}
