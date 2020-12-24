<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\Ramsey\Uuid\Uuid;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\DeadCode\Doctrine\DoctrineEntityManipulator;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Doctrine\Tests\Rector\MethodCall\ChangeSetIdToUuidValueRector\ChangeSetIdToUuidValueRectorTest
 */
final class ChangeSetIdToUuidValueRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineEntityManipulator
     */
    private $doctrineEntityManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\DeadCode\Doctrine\DoctrineEntityManipulator $doctrineEntityManipulator)
    {
        $this->doctrineEntityManipulator = $doctrineEntityManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change set id to uuid values', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

class SomeClass
{
    public function run()
    {
        $buildingFirst = new Building();
        $buildingFirst->setId(1);
        $buildingFirst->setUuid(Uuid::fromString('a3bfab84-e207-4ddd-b96d-488151de9e96'));
    }
}

/**
 * @ORM\Entity
 */
class Building
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

class SomeClass
{
    public function run()
    {
        $buildingFirst = new Building();
        $buildingFirst->setId(Uuid::fromString('a3bfab84-e207-4ddd-b96d-488151de9e96'));
    }
}

/**
 * @ORM\Entity
 */
class Building
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        // A. try find "setUuid()" call on the same object later
        $setUuidMethodCall = $this->getSetUuidMethodCallOnSameVariable($node);
        if ($setUuidMethodCall !== null) {
            $node->args = $setUuidMethodCall->args;
            $this->removeNode($setUuidMethodCall);
            return $node;
        }
        // B. is the value constant reference?
        $argumentValue = $node->args[0]->value;
        if ($argumentValue instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch) {
            $classConst = $this->nodeRepository->findClassConstByClassConstFetch($argumentValue);
            if ($classConst === null) {
                return null;
            }
            $constantValueStaticType = $this->getStaticType($classConst->consts[0]->value);
            // probably already uuid
            if ($constantValueStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StringType) {
                return null;
            }
            // update constant value
            $classConst->consts[0]->value = $this->createUuidStringNode();
            $node->args[0]->value = $this->createStaticCall(\_PhpScoperb75b35f52b74\Ramsey\Uuid\Uuid::class, 'fromString', [$argumentValue]);
            return $node;
        }
        // C. set uuid from string with generated string
        $value = $this->createStaticCall(\_PhpScoperb75b35f52b74\Ramsey\Uuid\Uuid::class, 'fromString', [$this->createUuidStringNode()]);
        $node->args[0]->value = $value;
        return $node;
    }
    private function shouldSkip(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->doctrineEntityManipulator->isMethodCallOnDoctrineEntity($methodCall, 'setId')) {
            return \true;
        }
        if (!isset($methodCall->args[0])) {
            return \true;
        }
        // already uuid static type
        return $this->isUuidType($methodCall->args[0]->value);
    }
    private function getSetUuidMethodCallOnSameVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        $parentNode = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            $parentNode = $parentNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if ($parentNode === null) {
            return null;
        }
        $variableName = $this->getName($methodCall->var);
        /** @var ObjectType $variableType */
        $variableType = $this->getStaticType($methodCall->var);
        $methodCall = $this->betterNodeFinder->findFirst($parentNode, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($variableName, $variableType) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
                return \false;
            }
            if (!$this->isName($node->var, $variableName)) {
                return \false;
            }
            if (!$this->isObjectType($node->var, $variableType)) {
                return \false;
            }
            return $this->isName($node->name, 'setUuid');
        });
        if ($methodCall instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return $methodCall;
        }
        return null;
    }
    private function createUuidStringNode() : \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_
    {
        $uuidValue = \_PhpScoperb75b35f52b74\Ramsey\Uuid\Uuid::uuid4();
        $uuidValueString = $uuidValue->toString();
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($uuidValueString);
    }
    private function isUuidType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        $argumentStaticType = $this->getStaticType($expr);
        // UUID is already set
        if (!$argumentStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $argumentStaticType->getClassName() === \_PhpScoperb75b35f52b74\Ramsey\Uuid\Uuid::class;
    }
}
