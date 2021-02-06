<?php

declare (strict_types=1);
namespace Rector\Doctrine\Rector\Class_;

use RectorPrefix20210206\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ObjectType;
use Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\Doctrine\NodeFactory\EntityUuidNodeFactory;
use Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Doctrine\Tests\Rector\Class_\AlwaysInitializeUuidInEntityRector\AlwaysInitializeUuidInEntityRectorTest
 */
final class AlwaysInitializeUuidInEntityRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var EntityUuidNodeFactory
     */
    private $entityUuidNodeFactory;
    /**
     * @var ClassDependencyManipulator
     */
    private $classDependencyManipulator;
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator $classDependencyManipulator, \Rector\Doctrine\NodeFactory\EntityUuidNodeFactory $entityUuidNodeFactory, \Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver)
    {
        $this->entityUuidNodeFactory = $entityUuidNodeFactory;
        $this->classDependencyManipulator = $classDependencyManipulator;
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add uuid initializion to all entities that misses it', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AddUuidInit
{
    /**
     * @ORM\Id
     * @var UuidInterface
     */
    private $superUuid;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AddUuidInit
{
    /**
     * @ORM\Id
     * @var UuidInterface
     */
    private $superUuid;
    public function __construct()
    {
        $this->superUuid = \Ramsey\Uuid\Uuid::uuid4();
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
        if (!$this->doctrineDocBlockResolver->isDoctrineEntityClass($node)) {
            return null;
        }
        $uuidProperty = $this->resolveUuidPropertyFromClass($node);
        if (!$uuidProperty instanceof \PhpParser\Node\Stmt\Property) {
            return null;
        }
        $uuidPropertyName = $this->getName($uuidProperty);
        if ($this->hasUuidInitAlreadyAdded($node, $uuidPropertyName)) {
            return null;
        }
        $stmts = [];
        $stmts[] = $this->entityUuidNodeFactory->createUuidPropertyDefaultValueAssign($uuidPropertyName);
        $this->classDependencyManipulator->addStmtsToConstructorIfNotThereYet($node, $stmts);
        return $node;
    }
    private function resolveUuidPropertyFromClass(\PhpParser\Node\Stmt\Class_ $class) : ?\PhpParser\Node\Stmt\Property
    {
        foreach ($class->getProperties() as $property) {
            $propertyPhpDoc = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
            $varType = $propertyPhpDoc->getVarType();
            if (!$varType instanceof \PHPStan\Type\ObjectType) {
                continue;
            }
            if (!\RectorPrefix20210206\Nette\Utils\Strings::contains($varType->getClassName(), 'UuidInterface')) {
                continue;
            }
            return $property;
        }
        return null;
    }
    private function hasUuidInitAlreadyAdded(\PhpParser\Node\Stmt\Class_ $class, string $uuidPropertyName) : bool
    {
        $constructClassMethod = $class->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if (!$constructClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        return (bool) $this->betterNodeFinder->findFirst($class->stmts, function (\PhpParser\Node $node) use($uuidPropertyName) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return \false;
            }
            if (!$this->isStaticCallNamed($node->expr, 'Ramsey\\Uuid\\Uuid', 'uuid4')) {
                return \false;
            }
            return $this->isName($node->var, $uuidPropertyName);
        });
    }
}
