<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\ValueObject\ArrayCallable;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddMethodCallBasedParamTypeRector\AddMethodCallBasedParamTypeRectorTest
 */
final class AddMethodCallBasedParamTypeRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change param type of passed getId() to UuidInterface type declaration', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
            if (!$classMethodCall instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall && !$classMethodCall instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
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
    private function shouldSkipArgumentStaticType(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $argumentStaticType, int $position) : bool
    {
        if ($argumentStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
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
