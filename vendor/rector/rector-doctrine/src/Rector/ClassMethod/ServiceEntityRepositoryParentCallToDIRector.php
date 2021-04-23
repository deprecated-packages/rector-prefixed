<?php

declare (strict_types=1);
namespace Rector\Doctrine\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\ObjectType;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\NodeManipulator\ClassDependencyManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\Doctrine\NodeFactory\RepositoryNodeFactory;
use Rector\Doctrine\Type\RepositoryTypeFactory;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Collector\PropertyToAddCollector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://tomasvotruba.com/blog/2017/10/16/how-to-use-repository-with-doctrine-as-service-in-symfony/
 * @see https://getrector.org/blog/2021/02/08/how-to-instantly-decouple-symfony-doctrine-repository-inheritance-to-clean-composition
 *
 * @see \Rector\Doctrine\Tests\Rector\ClassMethod\ServiceEntityRepositoryParentCallToDIRector\ServiceEntityRepositoryParentCallToDIRectorTest
 */
final class ServiceEntityRepositoryParentCallToDIRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var RepositoryNodeFactory
     */
    private $repositoryNodeFactory;
    /**
     * @var RepositoryTypeFactory
     */
    private $repositoryTypeFactory;
    /**
     * @var PropertyToAddCollector
     */
    private $propertyToAddCollector;
    /**
     * @var ClassDependencyManipulator
     */
    private $classDependencyManipulator;
    public function __construct(\Rector\Doctrine\NodeFactory\RepositoryNodeFactory $repositoryNodeFactory, \Rector\Doctrine\Type\RepositoryTypeFactory $repositoryTypeFactory, \Rector\PostRector\Collector\PropertyToAddCollector $propertyToAddCollector, \Rector\Core\NodeManipulator\ClassDependencyManipulator $classDependencyManipulator)
    {
        $this->repositoryNodeFactory = $repositoryNodeFactory;
        $this->repositoryTypeFactory = $repositoryTypeFactory;
        $this->propertyToAddCollector = $propertyToAddCollector;
        $this->classDependencyManipulator = $classDependencyManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change ServiceEntityRepository to dependency injection, with repository property', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ProjectRepository extends ServiceEntityRepository
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \Doctrine\ORM\EntityRepository<Project>
     */
    private $repository;

    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Project::class);
        $this->entityManager = $entityManager;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     *
     * For reference, possible manager registry param types:
     * - Doctrine\Common\Persistence\ManagerRegistry
     * - Doctrine\Persistence\ManagerRegistry
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkipClassMethod($node)) {
            return null;
        }
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        // 1. remove params
        $node->params = [];
        // 2. remove parent::__construct()
        $entityReferenceExpr = $this->removeParentConstructAndCollectEntityReference($node);
        // 3. add $entityManager->getRepository() fetch assign
        $repositoryAssign = $this->repositoryNodeFactory->createRepositoryAssign($entityReferenceExpr);
        $entityManagerObjectType = new \PHPStan\Type\ObjectType('Doctrine\\ORM\\EntityManagerInterface');
        $this->classDependencyManipulator->addConstructorDependencyWithCustomAssign($classLike, 'entityManager', $entityManagerObjectType, $repositoryAssign);
        $this->addRepositoryProperty($classLike, $entityReferenceExpr);
        // 5. add param + add property, dependency
        $this->propertyAdder->addServiceConstructorDependencyToClass($classLike, $entityManagerObjectType);
        return $node;
    }
    private function shouldSkipClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isName($classMethod, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return \true;
        }
        $scope = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            // fresh node?
            return \true;
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            // possibly trait/interface
            return \true;
        }
        return !$classReflection->isSubclassOf('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository');
    }
    private function removeParentConstructAndCollectEntityReference(\PhpParser\Node\Stmt\ClassMethod $classMethod) : \PhpParser\Node\Expr
    {
        $entityReferenceExpr = null;
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) use(&$entityReferenceExpr) {
            if (!$node instanceof \PhpParser\Node\Expr\StaticCall) {
                return null;
            }
            if (!$this->isName($node->class, 'parent')) {
                return null;
            }
            $entityReferenceExpr = $node->args[1]->value;
            $this->removeNode($node);
        });
        if ($entityReferenceExpr === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return $entityReferenceExpr;
    }
    private function addRepositoryProperty(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Expr $entityReferenceExpr) : void
    {
        $genericObjectType = $this->repositoryTypeFactory->createRepositoryPropertyType($entityReferenceExpr);
        $this->propertyToAddCollector->addPropertyWithoutConstructorToClass('repository', $genericObjectType, $class);
    }
}
