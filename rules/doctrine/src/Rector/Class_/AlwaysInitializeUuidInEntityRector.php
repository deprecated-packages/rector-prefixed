<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Class_;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\Doctrine\NodeFactory\EntityUuidNodeFactory;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Doctrine\Tests\Rector\Class_\AlwaysInitializeUuidInEntityRector\AlwaysInitializeUuidInEntityRectorTest
 */
final class AlwaysInitializeUuidInEntityRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var EntityUuidNodeFactory
     */
    private $entityUuidNodeFactory;
    /**
     * @var ClassDependencyManipulator
     */
    private $classDependencyManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassDependencyManipulator $classDependencyManipulator, \_PhpScoperb75b35f52b74\Rector\Doctrine\NodeFactory\EntityUuidNodeFactory $entityUuidNodeFactory)
    {
        $this->entityUuidNodeFactory = $entityUuidNodeFactory;
        $this->classDependencyManipulator = $classDependencyManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add uuid initializion to all entities that misses it', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
    private function resolveUuidPropertyFromClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        foreach ($class->getProperties() as $property) {
            $propertyPhpDoc = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($propertyPhpDoc === null) {
                continue;
            }
            $varType = $propertyPhpDoc->getVarType();
            if (!$varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
                continue;
            }
            if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($varType->getClassName(), 'UuidInterface')) {
                continue;
            }
            return $property;
        }
        return null;
    }
    private function hasUuidInitAlreadyAdded(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, string $uuidPropertyName) : bool
    {
        $constructClassMethod = $class->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return \false;
        }
        return (bool) $this->betterNodeFinder->findFirst((array) $class->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($uuidPropertyName) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            if (!$this->isStaticCallNamed($node->expr, '_PhpScoperb75b35f52b74\\Ramsey\\Uuid\\Uuid', 'uuid4')) {
                return \false;
            }
            return $this->isName($node->var, $uuidPropertyName);
        });
    }
}
