<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param string[] $types
     * @return ObjectType[]
     */
    public function collectStaticCallTypeInClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, array $types) : array
    {
        $staticTypesInClass = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $class) use($types, &$staticTypesInClass) {
            if (!$class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
                return null;
            }
            foreach ($types as $type) {
                if ($this->nodeTypeResolver->isObjectType($class->class, $type)) {
                    $staticTypesInClass[] = new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($type);
                }
            }
            return null;
        });
        return $staticTypesInClass;
    }
}
