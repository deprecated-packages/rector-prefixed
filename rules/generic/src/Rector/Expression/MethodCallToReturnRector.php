<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\Expression;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\MethodCallToReturn;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\MethodCallToReturnRectorTest
 */
final class MethodCallToReturnRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_CALL_WRAPS = 'method_call_wraps';
    /**
     * @var MethodCallToReturn[]
     */
    private $methodCallWraps = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Wrap method call to return', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->deny();
    }

    public function deny()
    {
        return 1;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return $this->deny();
    }

    public function deny()
    {
        return 1;
    }
}
CODE_SAMPLE
, [self::METHOD_CALL_WRAPS => ['SomeClass' => ['deny']]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression::class];
    }
    /**
     * @param Expression $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        $methodCall = $node->expr;
        return $this->refactorMethodCall($methodCall);
    }
    public function configure(array $configuration) : void
    {
        $methodCallWraps = $configuration[self::METHOD_CALL_WRAPS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($methodCallWraps, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\MethodCallToReturn::class);
        $this->methodCallWraps = $methodCallWraps;
    }
    private function refactorMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->methodCallWraps as $methodCallWrap) {
            if (!$this->isObjectType($methodCall->var, $methodCallWrap->getClass())) {
                continue;
            }
            if (!$this->isName($methodCall->name, $methodCallWrap->getMethod())) {
                continue;
            }
            $parentNode = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            // already wrapped
            if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
                continue;
            }
            $return = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($methodCall);
            $methodCall->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $return);
            return $return;
        }
        return null;
    }
}
