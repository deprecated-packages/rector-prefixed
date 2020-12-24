<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Rector\Class_;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName;
use _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\NodeFactory\EntityUuidNodeFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Doctrine\Tests\Rector\Class_\AlwaysInitializeUuidInEntityRector\AlwaysInitializeUuidInEntityRectorTest
 */
final class AlwaysInitializeUuidInEntityRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var EntityUuidNodeFactory
     */
    private $entityUuidNodeFactory;
    /**
     * @var ClassDependencyManipulator
     */
    private $classDependencyManipulator;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator $classDependencyManipulator, \_PhpScoper2a4e7ab1ecbc\Rector\Doctrine\NodeFactory\EntityUuidNodeFactory $entityUuidNodeFactory)
    {
        $this->entityUuidNodeFactory = $entityUuidNodeFactory;
        $this->classDependencyManipulator = $classDependencyManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add uuid initializion to all entities that misses it', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isDoctrineEntityClass($node)) {
            return null;
        }
        $uuidProperty = $this->resolveUuidPropertyFromClass($node);
        if ($uuidProperty === null) {
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
    private function resolveUuidPropertyFromClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property
    {
        foreach ($class->getProperties() as $property) {
            $propertyPhpDoc = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($propertyPhpDoc === null) {
                continue;
            }
            $varType = $propertyPhpDoc->getVarType();
            if (!$varType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
                continue;
            }
            if (!\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($varType->getClassName(), 'UuidInterface')) {
                continue;
            }
            return $property;
        }
        return null;
    }
    private function hasUuidInitAlreadyAdded(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, string $uuidPropertyName) : bool
    {
        $constructClassMethod = $class->getMethod(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return \false;
        }
        return (bool) $this->betterNodeFinder->findFirst((array) $class->stmts, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($uuidPropertyName) : bool {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            if (!$this->isStaticCallNamed($node->expr, '_PhpScoper2a4e7ab1ecbc\\Ramsey\\Uuid\\Uuid', 'uuid4')) {
                return \false;
            }
            return $this->isName($node->var, $uuidPropertyName);
        });
    }
}
