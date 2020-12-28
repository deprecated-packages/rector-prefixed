<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeCollector\ValueObject\ArrayCallable;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddMethodCallBasedParamTypeRector\AddMethodCallBasedParamTypeRectorTest
 */
final class AddMethodCallBasedParamTypeRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change param type of passed getId() to UuidInterface type declaration', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function getById($id)
    {
    }
}

class CallerClass
{
    public function run()
    {
        $building = new Building();
        $someClass = new SomeClass();
        $someClass->getById($building->getId());
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function getById(\Ramsey\Uuid\UuidInterface $id)
    {
    }
}

class CallerClass
{
    public function run()
    {
        $building = new Building();
        $someClass = new SomeClass();
        $someClass->getById($building->getId());
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $classMethodCalls = $this->nodeRepository->findCallsByClassMethod($node);
        $classParameterTypes = $this->getCallTypesByPosition($classMethodCalls);
        foreach ($classParameterTypes as $position => $argumentStaticType) {
            if ($this->shouldSkipArgumentStaticType($node, $argumentStaticType, $position)) {
                continue;
            }
            $phpParserTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($argumentStaticType);
            // update parameter
            $node->params[$position]->type = $phpParserTypeNode;
        }
        return $node;
    }
    /**
     * @param MethodCall[]|StaticCall[]|ArrayCallable[] $classMethodCalls
     * @return Type[]
     */
    private function getCallTypesByPosition(array $classMethodCalls) : array
    {
        $staticTypesByArgumentPosition = [];
        foreach ($classMethodCalls as $classMethodCall) {
            if (!$classMethodCall instanceof \PhpParser\Node\Expr\StaticCall && !$classMethodCall instanceof \PhpParser\Node\Expr\MethodCall) {
                continue;
            }
            foreach ($classMethodCall->args as $position => $arg) {
                $staticTypesByArgumentPosition[$position][] = $this->getStaticType($arg->value);
            }
        }
        // unite to single type
        $staticTypeByArgumentPosition = [];
        foreach ($staticTypesByArgumentPosition as $position => $staticTypes) {
            $staticTypeByArgumentPosition[$position] = $this->typeFactory->createMixedPassedOrUnionType($staticTypes);
        }
        return $staticTypeByArgumentPosition;
    }
    private function shouldSkipArgumentStaticType(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PHPStan\Type\Type $argumentStaticType, int $position) : bool
    {
        if ($argumentStaticType instanceof \PHPStan\Type\MixedType) {
            return \true;
        }
        if (!isset($classMethod->params[$position])) {
            return \true;
        }
        $parameter = $classMethod->params[$position];
        if ($parameter->type === null) {
            return \false;
        }
        $parameterStaticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($parameter->type);
        // already completed → skip
        return $parameterStaticType->equals($argumentStaticType);
    }
}
