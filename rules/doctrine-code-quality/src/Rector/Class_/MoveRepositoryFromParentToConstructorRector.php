<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\Rector\Class_;

use _PhpScoperb75b35f52b74\Doctrine\ORM\EntityManager;
use _PhpScoperb75b35f52b74\Doctrine\ORM\EntityRepository;
use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\Bridge\RectorProviderException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\DoctrineRepositoryAsServiceTest
 */
final class MoveRepositoryFromParentToConstructorRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator $classDependencyManipulator, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \_PhpScoperb75b35f52b74\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface $doctrineEntityAndRepositoryMapper)
    {
        $this->doctrineEntityAndRepositoryMapper = $doctrineEntityAndRepositoryMapper;
        $this->classDependencyManipulator = $classDependencyManipulator;
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns parent EntityRepository class to constructor dependency', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node->extends === null) {
            return null;
        }
        $parentClassName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName !== \_PhpScoperb75b35f52b74\Doctrine\ORM\EntityRepository::class) {
            return null;
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($className, 'Repository')) {
            return null;
        }
        // remove parent class
        $node->extends = null;
        // add $repository property
        $this->classInsertManipulator->addPropertyToClass($node, 'repository', new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\_PhpScoperb75b35f52b74\Doctrine\ORM\EntityRepository::class));
        // add $entityManager and assign to constuctor
        $this->classDependencyManipulator->addConstructorDependencyWithCustomAssign($node, 'entityManager', new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\_PhpScoperb75b35f52b74\Doctrine\ORM\EntityManager::class), $this->createRepositoryAssign($node));
        return $node;
    }
    /**
     * Creates:
     * "$this->repository = $entityManager->getRepository()"
     */
    private function createRepositoryAssign(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        $repositoryClassName = (string) $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $entityClassName = $this->doctrineEntityAndRepositoryMapper->mapRepositoryToEntity($repositoryClassName);
        if ($entityClassName === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\Bridge\RectorProviderException(\sprintf('An entity was not provided for "%s" repository by your "%s" class.', $repositoryClassName, \get_class($this->doctrineEntityAndRepositoryMapper)));
        }
        $classConstFetch = $this->createClassConstantReference($entityClassName);
        $methodCall = $this->builderFactory->methodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('entityManager'), 'getRepository', [$classConstFetch]);
        $methodCall->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, $class);
        return $this->createPropertyAssignmentWithExpr('repository', $methodCall);
    }
}
