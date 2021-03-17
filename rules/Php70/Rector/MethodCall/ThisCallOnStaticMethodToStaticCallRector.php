<?php

declare (strict_types=1);
namespace Rector\Php70\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Reflection\Php\PhpMethodReflection;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeCollector\Reflection\MethodReflectionProvider;
use Rector\NodeCollector\StaticAnalyzer;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/rkiSC
 * @see \Rector\Tests\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector\ThisCallOnStaticMethodToStaticCallRectorTest
 */
final class ThisCallOnStaticMethodToStaticCallRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var StaticAnalyzer
     */
    private $staticAnalyzer;
    /**
     * @var MethodReflectionProvider
     */
    private $methodReflectionProvider;
    /**
     * @param \Rector\NodeCollector\StaticAnalyzer $staticAnalyzer
     * @param \Rector\NodeCollector\Reflection\MethodReflectionProvider $methodReflectionProvider
     */
    public function __construct($staticAnalyzer, $methodReflectionProvider)
    {
        $this->staticAnalyzer = $staticAnalyzer;
        $this->methodReflectionProvider = $methodReflectionProvider;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes $this->call() to static method to static call', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public static function run()
    {
        $this->eat();
    }

    public static function eat()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public static function run()
    {
        static::eat();
    }

    public static function eat()
    {
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        if (!$this->nodeNameResolver->isVariableName($node->var, 'this')) {
            return null;
        }
        $methodName = $this->getName($node->name);
        if ($methodName === null) {
            return null;
        }
        // skip PHPUnit calls, as they accept both self:: and $this-> formats
        if ($this->isObjectType($node->var, new \PHPStan\Type\ObjectType('PHPUnit\\Framework\\TestCase'))) {
            return null;
        }
        /** @var class-string $className */
        $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\is_string($className)) {
            return null;
        }
        $isStaticMethod = $this->staticAnalyzer->isStaticMethod($methodName, $className);
        if (!$isStaticMethod) {
            return null;
        }
        $classReference = $this->resolveClassSelf($node);
        return $this->nodeFactory->createStaticCall($classReference, $methodName, $node->args);
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    private function resolveClassSelf($methodCall) : string
    {
        $classLike = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return 'static';
        }
        if ($classLike->isFinal()) {
            return 'self';
        }
        $methodReflection = $this->methodReflectionProvider->provideByMethodCall($methodCall);
        if (!$methodReflection instanceof \PHPStan\Reflection\Php\PhpMethodReflection) {
            return 'static';
        }
        if (!$methodReflection->isPrivate()) {
            return 'static';
        }
        return 'self';
    }
}
