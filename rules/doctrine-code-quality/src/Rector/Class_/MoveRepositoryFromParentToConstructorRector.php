<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\Rector\Class_;

use RectorPrefix20210202\Doctrine\ORM\EntityManager;
use RectorPrefix20210202\Doctrine\ORM\EntityRepository;
use RectorPrefix20210202\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\ObjectType;
use PHPStan\Type\TypeWithClassName;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator;
use Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\DoctrineCodeQuality\NodeAnalyzer\EntityObjectTypeResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\DoctrineRepositoryAsServiceTest
 */
final class MoveRepositoryFromParentToConstructorRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassDependencyManipulator
     */
    private $classDependencyManipulator;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    /**
     * @var EntityObjectTypeResolver
     */
    private $entityObjectTypeResolver;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator $classDependencyManipulator, \Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \Rector\DoctrineCodeQuality\NodeAnalyzer\EntityObjectTypeResolver $entityObjectTypeResolver)
    {
        $this->classDependencyManipulator = $classDependencyManipulator;
        $this->classInsertManipulator = $classInsertManipulator;
        $this->entityObjectTypeResolver = $entityObjectTypeResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns parent EntityRepository class to constructor dependency', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
namespace App\Repository;

use Doctrine\ORM\EntityRepository;

final class PostRepository extends EntityRepository
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\EntityRepository;

final class PostRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(\App\Entity\Post::class);
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
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->extends === null) {
            return null;
        }
        $parentClassName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName !== \RectorPrefix20210202\Doctrine\ORM\EntityRepository::class) {
            return null;
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        if (!\RectorPrefix20210202\Nette\Utils\Strings::endsWith($className, 'Repository')) {
            return null;
        }
        // remove parent class
        $node->extends = null;
        // add $repository property
        $this->classInsertManipulator->addPropertyToClass($node, 'repository', new \PHPStan\Type\ObjectType(\RectorPrefix20210202\Doctrine\ORM\EntityRepository::class));
        // add $entityManager and assign to constuctor
        $this->classDependencyManipulator->addConstructorDependencyWithCustomAssign($node, 'entityManager', new \PHPStan\Type\ObjectType(\RectorPrefix20210202\Doctrine\ORM\EntityManager::class), $this->createRepositoryAssign($node));
        return $node;
    }
    /**
     * Creates:
     * "$this->repository = $entityManager->getRepository(SomeEntityClass::class)"
     */
    private function createRepositoryAssign(\PhpParser\Node\Stmt\Class_ $repositoryClass) : \PhpParser\Node\Expr\Assign
    {
        $entityObjectType = $this->entityObjectTypeResolver->resolveFromRepositoryClass($repositoryClass);
        $repositoryClassName = (string) $repositoryClass->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!$entityObjectType instanceof \PHPStan\Type\TypeWithClassName) {
            throw new \Rector\Core\Exception\ShouldNotHappenException(\sprintf('An entity was not found for "%s" repository.', $repositoryClassName));
        }
        $classConstFetch = $this->nodeFactory->createClassConstReference($entityObjectType->getClassName());
        $methodCall = $this->builderFactory->methodCall(new \PhpParser\Node\Expr\Variable('entityManager'), 'getRepository', [$classConstFetch]);
        $methodCall->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, $repositoryClassName);
        return $this->nodeFactory->createPropertyAssignmentWithExpr('repository', $methodCall);
    }
}
