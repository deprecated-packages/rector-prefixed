<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\Class_\ManagerRegistryGetManagerToEntityManagerRector\ManagerRegistryGetManagerToEntityManagerRectorTest
 */
final class ManagerRegistryGetManagerToEntityManagerRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const GET_MANAGER = 'getManager';
    /**
     * @var string
     */
    private const ENTITY_MANAGER = 'entityManager';
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes ManagerRegistry intermediate calls directly to EntityManager calls', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $constructorClassMethod = $node->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
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
        $this->addConstructorDependencyWithProperty($node, $constructorClassMethod, self::ENTITY_MANAGER, new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType('_PhpScoperb75b35f52b74\\Doctrine\\ORM\\EntityManagerInterface'));
        return $node;
    }
    /**
     * @return string[]
     */
    private function resolveManagerRegistryCalledMethodNames(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $registryCalledMethods = [];
        $this->traverseNodesWithCallable($class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$registryCalledMethods) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->isObjectType($node->var, '_PhpScoperb75b35f52b74\\Doctrine\\Common\\Persistence\\ManagerRegistry')) {
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
    private function resolveManagerRegistryParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Param
    {
        foreach ($classMethod->params as $param) {
            if ($param->type === null) {
                continue;
            }
            if (!$this->isName($param->type, '_PhpScoperb75b35f52b74\\Doctrine\\Common\\Persistence\\ManagerRegistry')) {
                continue;
            }
            $classMethod->params[] = $this->createEntityManagerParam();
            return $param;
        }
        return null;
    }
    private function removeManagerRegistryDependency(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $registryParam) : void
    {
        // remove constructor param: $managerRegistry
        foreach ($classMethod->params as $key => $param) {
            if ($param->type === null) {
                continue;
            }
            if (!$this->isName($param->type, '_PhpScoperb75b35f52b74\\Doctrine\\Common\\Persistence\\ManagerRegistry')) {
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
    private function replaceEntityRegistryVariableWithEntityManagerProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->traverseNodesWithCallable($class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $class) : ?PropertyFetch {
            if (!$class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return null;
            }
            if (!$this->isObjectType($class, '_PhpScoperb75b35f52b74\\Doctrine\\Common\\Persistence\\ObjectManager')) {
                return null;
            }
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), self::ENTITY_MANAGER);
        });
    }
    private function removeAssignGetRepositoryCalls(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $this->traverseNodesWithCallable($class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->isRegistryGetManagerMethodCall($node)) {
                return null;
            }
            $this->removeNode($node);
        });
    }
    private function addConstructorDependencyWithProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, string $name, \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : void
    {
        $assign = $this->nodeFactory->createPropertyAssignment($name);
        $classMethod->stmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
        $this->addConstructorDependencyToClass($class, $fullyQualifiedObjectType, $name);
    }
    private function createEntityManagerParam() : \_PhpScoperb75b35f52b74\PhpParser\Node\Param
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Param(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable(self::ENTITY_MANAGER), null, new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\Doctrine\\ORM\\EntityManagerInterface'));
    }
    private function removeRegistryDependencyAssign(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $registryParam) : void
    {
        foreach ((array) $classMethod->stmts as $constructorMethodStmt) {
            if (!$constructorMethodStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            if (!$constructorMethodStmt->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
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
    private function isRegistryGetManagerMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : bool
    {
        if (!$assign->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->isObjectType($assign->expr->var, '_PhpScoperb75b35f52b74\\Doctrine\\Common\\Persistence\\ManagerRegistry')) {
            return \false;
        }
        return $this->isName($assign->expr->name, self::GET_MANAGER);
    }
    private function removeManagerRegistryProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : void
    {
        $managerRegistryPropertyName = $this->getName($assign->var);
        $this->traverseNodesWithCallable($class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($managerRegistryPropertyName) : ?int {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property) {
                return null;
            }
            if (!$this->isName($node, $managerRegistryPropertyName)) {
                return null;
            }
            $this->removeNode($node);
            return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
    }
}
