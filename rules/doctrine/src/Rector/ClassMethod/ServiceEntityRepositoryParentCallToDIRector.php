<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Doctrine\NodeFactory\RepositoryNodeFactory;
use _PhpScoperb75b35f52b74\Rector\Doctrine\Type\RepositoryTypeFactory;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://www.luzanky.cz/ for sponsoring this rule
 *
 * @see https://tomasvotruba.com/blog/2017/10/16/how-to-use-repository-with-doctrine-as-service-in-symfony/
 *
 * @see \Rector\Doctrine\Tests\Rector\ClassMethod\ServiceEntityRepositoryParentCallToDIRector\ServiceEntityRepositoryParentCallToDIRectorTest
 */
final class ServiceEntityRepositoryParentCallToDIRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const SERVICE_ENTITY_REPOSITORY_CLASS = '_PhpScoperb75b35f52b74\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository';
    /**
     * @var RepositoryNodeFactory
     */
    private $repositoryNodeFactory;
    /**
     * @var RepositoryTypeFactory
     */
    private $repositoryTypeFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Doctrine\NodeFactory\RepositoryNodeFactory $repositoryNodeFactory, \_PhpScoperb75b35f52b74\Rector\Doctrine\Type\RepositoryTypeFactory $repositoryTypeFactory)
    {
        $this->repositoryNodeFactory = $repositoryNodeFactory;
        $this->repositoryTypeFactory = $repositoryTypeFactory;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change ServiceEntityRepository to dependency injection, with repository property', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     *
     * For reference, possible manager registry param types:
     * - Doctrine\Common\Persistence\ManagerRegistry
     * - Doctrine\Persistence\ManagerRegistry
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->shouldSkipClassMethod($node)) {
            return null;
        }
        /** @var ClassLike|null $classLike */
        $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        // 1. remove params
        $node->params = [];
        // 2. remove parent::__construct()
        $entityReferenceExpr = $this->removeParentConstructAndCollectEntityReference($node);
        // 3. add $entityManager->getRepository() fetch assign
        $node->stmts[] = $this->repositoryNodeFactory->createRepositoryAssign($entityReferenceExpr);
        // 4. add $repository property
        $this->addRepositoryProperty($classLike, $entityReferenceExpr);
        // 5. add param + add property, dependency
        $this->addServiceConstructorDependencyToClass($classLike, '_PhpScoperb75b35f52b74\\Doctrine\\ORM\\EntityManagerInterface');
        return $node;
    }
    private function shouldSkipClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string|null $parentClassName */
        $parentClassName = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName === null) {
            return \true;
        }
        return $parentClassName !== self::SERVICE_ENTITY_REPOSITORY_CLASS;
    }
    private function removeParentConstructAndCollectEntityReference(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        $entityReferenceExpr = null;
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$entityReferenceExpr) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
                return null;
            }
            if (!$this->isName($node->class, 'parent')) {
                return null;
            }
            $entityReferenceExpr = $node->args[1]->value;
            $this->removeNode($node);
        });
        if ($entityReferenceExpr === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $entityReferenceExpr;
    }
    private function addRepositoryProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $entityReferenceExpr) : void
    {
        $genericObjectType = $this->repositoryTypeFactory->createRepositoryPropertyType($entityReferenceExpr);
        $this->addPropertyToClass($class, $genericObjectType, 'repository');
    }
}
