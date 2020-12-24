<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DoctrineCodeQuality\Rector\Class_;

use _PhpScoper2a4e7ab1ecbc\Doctrine\ORM\EntityManager;
use _PhpScoper2a4e7ab1ecbc\Doctrine\ORM\EntityRepository;
use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\Bridge\RectorProviderException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\DoctrineRepositoryAsServiceTest
 */
final class MoveRepositoryFromParentToConstructorRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineEntityAndRepositoryMapperInterface
     */
    private $doctrineEntityAndRepositoryMapper;
    /**
     * @var ClassDependencyManipulator
     */
    private $classDependencyManipulator;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator $classDependencyManipulator, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \_PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface $doctrineEntityAndRepositoryMapper)
    {
        $this->doctrineEntityAndRepositoryMapper = $doctrineEntityAndRepositoryMapper;
        $this->classDependencyManipulator = $classDependencyManipulator;
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns parent EntityRepository class to constructor dependency', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($node->extends === null) {
            return null;
        }
        $parentClassName = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName !== \_PhpScoper2a4e7ab1ecbc\Doctrine\ORM\EntityRepository::class) {
            return null;
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        if (!\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::endsWith($className, 'Repository')) {
            return null;
        }
        // remove parent class
        $node->extends = null;
        // add $repository property
        $this->classInsertManipulator->addPropertyToClass($node, 'repository', new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType(\_PhpScoper2a4e7ab1ecbc\Doctrine\ORM\EntityRepository::class));
        // add $entityManager and assign to constuctor
        $this->classDependencyManipulator->addConstructorDependencyWithCustomAssign($node, 'entityManager', new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType(\_PhpScoper2a4e7ab1ecbc\Doctrine\ORM\EntityManager::class), $this->createRepositoryAssign($node));
        return $node;
    }
    /**
     * Creates:
     * "$this->repository = $entityManager->getRepository()"
     */
    private function createRepositoryAssign(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign
    {
        $repositoryClassName = (string) $class->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $entityClassName = $this->doctrineEntityAndRepositoryMapper->mapRepositoryToEntity($repositoryClassName);
        if ($entityClassName === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\Bridge\RectorProviderException(\sprintf('An entity was not provided for "%s" repository by your "%s" class.', $repositoryClassName, \get_class($this->doctrineEntityAndRepositoryMapper)));
        }
        $classConstFetch = $this->createClassConstantReference($entityClassName);
        $methodCall = $this->builderFactory->methodCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('entityManager'), 'getRepository', [$classConstFetch]);
        $methodCall->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, $class);
        return $this->createPropertyAssignmentWithExpr('repository', $methodCall);
    }
}
