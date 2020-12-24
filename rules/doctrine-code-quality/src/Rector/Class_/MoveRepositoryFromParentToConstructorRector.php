<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\Rector\Class_;

use _PhpScoper0a6b37af0871\Doctrine\ORM\EntityManager;
use _PhpScoper0a6b37af0871\Doctrine\ORM\EntityRepository;
use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\Bridge\RectorProviderException;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\DoctrineRepositoryAsServiceTest
 */
final class MoveRepositoryFromParentToConstructorRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator $classDependencyManipulator, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \_PhpScoper0a6b37af0871\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface $doctrineEntityAndRepositoryMapper)
    {
        $this->doctrineEntityAndRepositoryMapper = $doctrineEntityAndRepositoryMapper;
        $this->classDependencyManipulator = $classDependencyManipulator;
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns parent EntityRepository class to constructor dependency', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node->extends === null) {
            return null;
        }
        $parentClassName = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName !== \_PhpScoper0a6b37af0871\Doctrine\ORM\EntityRepository::class) {
            return null;
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($className, 'Repository')) {
            return null;
        }
        // remove parent class
        $node->extends = null;
        // add $repository property
        $this->classInsertManipulator->addPropertyToClass($node, 'repository', new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\_PhpScoper0a6b37af0871\Doctrine\ORM\EntityRepository::class));
        // add $entityManager and assign to constuctor
        $this->classDependencyManipulator->addConstructorDependencyWithCustomAssign($node, 'entityManager', new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\_PhpScoper0a6b37af0871\Doctrine\ORM\EntityManager::class), $this->createRepositoryAssign($node));
        return $node;
    }
    /**
     * Creates:
     * "$this->repository = $entityManager->getRepository()"
     */
    private function createRepositoryAssign(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign
    {
        $repositoryClassName = (string) $class->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $entityClassName = $this->doctrineEntityAndRepositoryMapper->mapRepositoryToEntity($repositoryClassName);
        if ($entityClassName === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\Bridge\RectorProviderException(\sprintf('An entity was not provided for "%s" repository by your "%s" class.', $repositoryClassName, \get_class($this->doctrineEntityAndRepositoryMapper)));
        }
        $classConstFetch = $this->createClassConstantReference($entityClassName);
        $methodCall = $this->builderFactory->methodCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('entityManager'), 'getRepository', [$classConstFetch]);
        $methodCall->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE, $class);
        return $this->createPropertyAssignmentWithExpr('repository', $methodCall);
    }
}
