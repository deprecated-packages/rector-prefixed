<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\Class_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\Class_\ManagerRegistryGetManagerToEntityManagerRector\ManagerRegistryGetManagerToEntityManagerRectorTest
 */
final class ManagerRegistryGetManagerToEntityManagerRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const GET_MANAGER = 'getManager';
    /**
     * @var string
     */
    private const ENTITY_MANAGER = 'entityManager';
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes ManagerRegistry intermediate calls directly to EntityManager calls', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\Common\Persistence\ManagerRegistry;

class CustomRepository
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function run()
    {
        $entityManager = $this->managerRegistry->getManager();
        $someRepository = $entityManager->getRepository('Some');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\EntityManagerInterface;

class CustomRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function run()
    {
        $someRepository = $this->entityManager->getRepository('Some');
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $constructorClassMethod = $node->getMethod(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructorClassMethod === null) {
            return null;
        }
        // collect on registry method calls, so we know if the manager registry is needed
        $registryCalledMethods = $this->resolveManagerRegistryCalledMethodNames($node);
        if (!\in_array(self::GET_MANAGER, $registryCalledMethods, \true)) {
            return null;
        }
        $managerRegistryParam = $this->resolveManagerRegistryParam($constructorClassMethod);
        // no registry manager in the constructor
        if ($managerRegistryParam === null) {
            return null;
        }
        if ($registryCalledMethods === [self::GET_MANAGER]) {
            // the manager registry is needed only get entity manager → we don't need it now
            $this->removeManagerRegistryDependency($node, $constructorClassMethod, $managerRegistryParam);
        }
        $this->replaceEntityRegistryVariableWithEntityManagerProperty($node);
        $this->removeAssignGetRepositoryCalls($node);
        // add entity manager via constructor
        $this->addConstructorDependencyWithProperty($node, $constructorClassMethod, self::ENTITY_MANAGER, new \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType('_PhpScoper0a2ac50786fa\\Doctrine\\ORM\\EntityManagerInterface'));
        return $node;
    }
    /**
     * @return string[]
     */
    private function resolveManagerRegistryCalledMethodNames(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $registryCalledMethods = [];
        $this->traverseNodesWithCallable($class->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use(&$registryCalledMethods) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->isObjectType($node->var, '_PhpScoper0a2ac50786fa\\Doctrine\\Common\\Persistence\\ManagerRegistry')) {
                return null;
            }
            $name = $this->getName($node->name);
            if ($name === null) {
                return null;
            }
            $registryCalledMethods[] = $name;
        });
        return \array_unique($registryCalledMethods);
    }
    private function resolveManagerRegistryParam(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Param
    {
        foreach ($classMethod->params as $param) {
            if ($param->type === null) {
                continue;
            }
            if (!$this->isName($param->type, '_PhpScoper0a2ac50786fa\\Doctrine\\Common\\Persistence\\ManagerRegistry')) {
                continue;
            }
            $classMethod->params[] = $this->createEntityManagerParam();
            return $param;
        }
        return null;
    }
    private function removeManagerRegistryDependency(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\PhpParser\Node\Param $registryParam) : void
    {
        // remove constructor param: $managerRegistry
        foreach ($classMethod->params as $key => $param) {
            if ($param->type === null) {
                continue;
            }
            if (!$this->isName($param->type, '_PhpScoper0a2ac50786fa\\Doctrine\\Common\\Persistence\\ManagerRegistry')) {
                continue;
            }
            unset($classMethod->params[$key]);
        }
        $this->removeRegistryDependencyAssign($class, $classMethod, $registryParam);
    }
    /**
     * Before:
     * $entityRegistry->
     *
     * After:
     * $this->entityManager->
     */
    private function replaceEntityRegistryVariableWithEntityManagerProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->traverseNodesWithCallable($class->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $class) : ?PropertyFetch {
            if (!$class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                return null;
            }
            if (!$this->isObjectType($class, '_PhpScoper0a2ac50786fa\\Doctrine\\Common\\Persistence\\ObjectManager')) {
                return null;
            }
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('this'), self::ENTITY_MANAGER);
        });
    }
    private function removeAssignGetRepositoryCalls(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->traverseNodesWithCallable($class->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->isRegistryGetManagerMethodCall($node)) {
                return null;
            }
            $this->removeNode($node);
        });
    }
    private function addConstructorDependencyWithProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, string $name, \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : void
    {
        $assign = $this->nodeFactory->createPropertyAssignment($name);
        $classMethod->stmts[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($assign);
        $this->addConstructorDependencyToClass($class, $fullyQualifiedObjectType, $name);
    }
    private function createEntityManagerParam() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Param
    {
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Param(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable(self::ENTITY_MANAGER), null, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified('_PhpScoper0a2ac50786fa\\Doctrine\\ORM\\EntityManagerInterface'));
    }
    private function removeRegistryDependencyAssign(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\PhpParser\Node\Param $registryParam) : void
    {
        foreach ((array) $classMethod->stmts as $constructorMethodStmt) {
            if (!$constructorMethodStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            if (!$constructorMethodStmt->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                continue;
            }
            /** @var Assign $assign */
            $assign = $constructorMethodStmt->expr;
            if (!$this->areNamesEqual($assign->expr, $registryParam->var)) {
                continue;
            }
            $this->removeManagerRegistryProperty($class, $assign);
            // remove assign
            $this->removeNodeFromStatements($classMethod, $constructorMethodStmt);
            break;
        }
    }
    private function isRegistryGetManagerMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) : bool
    {
        if (!$assign->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->isObjectType($assign->expr->var, '_PhpScoper0a2ac50786fa\\Doctrine\\Common\\Persistence\\ManagerRegistry')) {
            return \false;
        }
        return $this->isName($assign->expr->name, self::GET_MANAGER);
    }
    private function removeManagerRegistryProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) : void
    {
        $managerRegistryPropertyName = $this->getName($assign->var);
        $this->traverseNodesWithCallable($class->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($managerRegistryPropertyName) : ?int {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property) {
                return null;
            }
            if (!$this->isName($node, $managerRegistryPropertyName)) {
                return null;
            }
            $this->removeNode($node);
            return \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
    }
}
