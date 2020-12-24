<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\RemovingStatic;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param string[] $types
     * @return ObjectType[]
     */
    public function collectStaticCallTypeInClass(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, array $types) : array
    {
        $staticTypesInClass = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($class->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $class) use($types, &$staticTypesInClass) {
            if (!$class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
                return null;
            }
            foreach ($types as $type) {
                if ($this->nodeTypeResolver->isObjectType($class->class, $type)) {
                    $staticTypesInClass[] = new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($type);
                }
            }
            return null;
        });
        return $staticTypesInClass;
    }
}
