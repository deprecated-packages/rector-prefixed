<?php

declare (strict_types=1);
namespace Rector\Doctrine\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\Expression;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use RectorPrefix20210222\Ramsey\Uuid\Uuid;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\Doctrine\DoctrineEntityManipulator;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Doctrine\Tests\Rector\MethodCall\ChangeSetIdToUuidValueRector\ChangeSetIdToUuidValueRectorTest
 */
final class ChangeSetIdToUuidValueRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineEntityManipulator
     */
    private $doctrineEntityManipulator;
    public function __construct(\Rector\DeadCode\Doctrine\DoctrineEntityManipulator $doctrineEntityManipulator)
    {
        $this->doctrineEntityManipulator = $doctrineEntityManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change set id to uuid values', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
        if ($argumentValue instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            $classConst = $this->nodeRepository->findClassConstByClassConstFetch($argumentValue);
            if (!$classConst instanceof \PhpParser\Node\Stmt\ClassConst) {
                return null;
            }
            $constantValueStaticType = $this->getStaticType($classConst->consts[0]->value);
            // probably already uuid
            if ($constantValueStaticType instanceof \PHPStan\Type\StringType) {
                return null;
            }
            // update constant value
            $classConst->consts[0]->value = $this->createUuidStringNode();
            $node->args[0]->value = $this->nodeFactory->createStaticCall(\RectorPrefix20210222\Ramsey\Uuid\Uuid::class, 'fromString', [$argumentValue]);
            return $node;
        }
        // C. set uuid from string with generated string
        $value = $this->nodeFactory->createStaticCall(\RectorPrefix20210222\Ramsey\Uuid\Uuid::class, 'fromString', [$this->createUuidStringNode()]);
        $node->args[0]->value = $value;
        return $node;
    }
    private function shouldSkip(\PhpParser\Node\Expr\MethodCall $methodCall) : bool
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
    private function getSetUuidMethodCallOnSameVariable(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node\Expr\MethodCall
    {
        $parentNode = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \PhpParser\Node\Stmt\Expression) {
            $parentNode = $parentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if (!$parentNode instanceof \PhpParser\Node) {
            return null;
        }
        $variableName = $this->getName($methodCall->var);
        if ($variableName === null) {
            return null;
        }
        /** @var ObjectType $variableType */
        $variableType = $this->getStaticType($methodCall->var);
        $methodCall = $this->betterNodeFinder->findFirst($parentNode, function (\PhpParser\Node $node) use($variableName, $variableType) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
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
        if ($methodCall instanceof \PhpParser\Node\Expr\MethodCall) {
            return $methodCall;
        }
        return null;
    }
    private function createUuidStringNode() : \PhpParser\Node\Scalar\String_
    {
        $uuidValue = \RectorPrefix20210222\Ramsey\Uuid\Uuid::uuid4();
        $uuidValueString = $uuidValue->toString();
        return new \PhpParser\Node\Scalar\String_($uuidValueString);
    }
    private function isUuidType(\PhpParser\Node\Expr $expr) : bool
    {
        $argumentStaticType = $this->getStaticType($expr);
        // UUID is already set
        if (!$argumentStaticType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        return $argumentStaticType->getClassName() === \RectorPrefix20210222\Ramsey\Uuid\Uuid::class;
    }
}
