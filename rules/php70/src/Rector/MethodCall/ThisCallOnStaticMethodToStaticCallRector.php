<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php70\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeCollector\StaticAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/rkiSC
 * @see \Rector\Php70\Tests\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector\ThisCallOnStaticMethodToStaticCallRectorTest
 */
final class ThisCallOnStaticMethodToStaticCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var StaticAnalyzer
     */
    private $staticAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeCollector\StaticAnalyzer $staticAnalyzer)
    {
        $this->staticAnalyzer = $staticAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes $this->call() to static method to static call', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isVariableName($node->var, 'this')) {
            return null;
        }
        // skip PHPUnit calls, as they accept both self:: and $this-> formats
        if ($this->isObjectType($node->var, '_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase')) {
            return null;
        }
        /** @var class-string $className */
        $className = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\is_string($className)) {
            return null;
        }
        $methodName = $this->getName($node->name);
        if ($methodName === null) {
            return null;
        }
        $isStaticMethod = $this->staticAnalyzer->isStaticMethod($methodName, $className);
        if (!$isStaticMethod) {
            return null;
        }
        return $this->createStaticCall('static', $methodName, $node->args);
    }
}
