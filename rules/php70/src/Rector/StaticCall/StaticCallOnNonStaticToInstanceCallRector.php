<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php70\Rector\StaticCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeCollector\StaticAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://thephp.cc/news/2017/07/dont-call-instance-methods-statically
 * @see https://3v4l.org/tQ32f
 * @see https://3v4l.org/jB9jn
 * @see https://stackoverflow.com/a/19694064/1348344
 *
 * @see \Rector\Php70\Tests\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector\StaticCallOnNonStaticToInstanceCallRectorTest
 */
final class StaticCallOnNonStaticToInstanceCallRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassMethodManipulator
     */
    private $classMethodManipulator;
    /**
     * @var StaticAnalyzer
     */
    private $staticAnalyzer;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator $classMethodManipulator, \_PhpScoper0a2ac50786fa\Rector\NodeCollector\StaticAnalyzer $staticAnalyzer)
    {
        $this->classMethodManipulator = $classMethodManipulator;
        $this->staticAnalyzer = $staticAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes static call to instance call, where not useful', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class Something
{
    public function doWork()
    {
    }
}

class Another
{
    public function run()
    {
        return Something::doWork();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class Something
{
    public function doWork()
    {
    }
}

class Another
{
    public function run()
    {
        return (new Something)->doWork();
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr) {
            return null;
        }
        $methodName = $this->getName($node->name);
        $className = $this->resolveStaticCallClassName($node);
        if ($methodName === null || $className === null) {
            return null;
        }
        if ($this->shouldSkip($methodName, $className, $node)) {
            return null;
        }
        if ($this->isInstantiable($className)) {
            $new = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_($node->class);
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($new, $node->name, $node->args);
        }
        // can we add static to method?
        $classMethodNode = $this->nodeRepository->findClassMethod($className, $methodName);
        if ($classMethodNode === null) {
            return null;
        }
        if ($this->classMethodManipulator->isStaticClassMethod($classMethodNode)) {
            return null;
        }
        $this->makeStatic($classMethodNode);
        return null;
    }
    private function resolveStaticCallClassName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $staticCall) : ?string
    {
        if ($staticCall->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
            $objectType = $this->getObjectType($staticCall->class);
            if ($objectType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType) {
                return $objectType->getClassName();
            }
        }
        return $this->getName($staticCall->class);
    }
    private function shouldSkip(string $methodName, string $className, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $staticCall) : bool
    {
        $isStaticMethod = $this->staticAnalyzer->isStaticMethod($methodName, $className);
        if ($isStaticMethod) {
            return \true;
        }
        if ($this->isNames($staticCall->class, ['self', 'parent', 'static', 'class'])) {
            return \true;
        }
        $parentClassName = $staticCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        return $className === $parentClassName;
    }
    private function isInstantiable(string $className) : bool
    {
        $reflectionClass = new \ReflectionClass($className);
        $classConstructorReflection = $reflectionClass->getConstructor();
        if ($classConstructorReflection === null) {
            return \true;
        }
        if (!$classConstructorReflection->isPublic()) {
            return \false;
        }
        // required parameters in constructor, nothing we can do
        return !(bool) $classConstructorReflection->getNumberOfRequiredParameters();
    }
}
