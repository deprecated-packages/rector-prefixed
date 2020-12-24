<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\ClassNameImport;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\UseUse;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class UsedImportsResolver
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var UseImportsTraverser
     */
    private $useImportsTraverser;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\CodingStyle\ClassNameImport\UseImportsTraverser $useImportsTraverser)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->useImportsTraverser = $useImportsTraverser;
    }
    /**
     * @return FullyQualifiedObjectType[]
     */
    public function resolveForNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : array
    {
        $namespace = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        if ($namespace instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_) {
            return $this->resolveForNamespace($namespace);
        }
        return [];
    }
    /**
     * @param Stmt[] $stmts
     * @return FullyQualifiedObjectType[]
     */
    public function resolveForStmts(array $stmts) : array
    {
        $usedImports = [];
        /** @var Class_|null $class */
        $class = $this->betterNodeFinder->findFirstInstanceOf($stmts, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class);
        // add class itself
        if ($class !== null) {
            $className = $this->nodeNameResolver->getName($class);
            if ($className !== null) {
                $usedImports[] = new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($className);
            }
        }
        $this->useImportsTraverser->traverserStmts($stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\UseUse $useUse, string $name) use(&$usedImports) : void {
            $usedImports[] = new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($name);
        });
        return $usedImports;
    }
    /**
     * @param Stmt[] $stmts
     * @return FullyQualifiedObjectType[]
     */
    public function resolveFunctionImportsForStmts(array $stmts) : array
    {
        $usedFunctionImports = [];
        $this->useImportsTraverser->traverserStmtsForFunctions($stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\UseUse $useUse, string $name) use(&$usedFunctionImports) : void {
            $usedFunctionImports[] = new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($name);
        });
        return $usedFunctionImports;
    }
    /**
     * @return FullyQualifiedObjectType[]
     */
    private function resolveForNamespace(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        return $this->resolveForStmts($namespace->stmts);
    }
}
