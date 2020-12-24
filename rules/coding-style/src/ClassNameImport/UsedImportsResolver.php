<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\UseImportsTraverser $useImportsTraverser)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->useImportsTraverser = $useImportsTraverser;
    }
    /**
     * @return FullyQualifiedObjectType[]
     */
    public function resolveForNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        $namespace = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        if ($namespace instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_) {
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
        $class = $this->betterNodeFinder->findFirstInstanceOf($stmts, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class);
        // add class itself
        if ($class !== null) {
            $className = $this->nodeNameResolver->getName($class);
            if ($className !== null) {
                $usedImports[] = new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($className);
            }
        }
        $this->useImportsTraverser->traverserStmts($stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse $useUse, string $name) use(&$usedImports) : void {
            $usedImports[] = new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($name);
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
        $this->useImportsTraverser->traverserStmtsForFunctions($stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse $useUse, string $name) use(&$usedFunctionImports) : void {
            $usedFunctionImports[] = new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($name);
        });
        return $usedFunctionImports;
    }
    /**
     * @return FullyQualifiedObjectType[]
     */
    private function resolveForNamespace(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        return $this->resolveForStmts($namespace->stmts);
    }
}
