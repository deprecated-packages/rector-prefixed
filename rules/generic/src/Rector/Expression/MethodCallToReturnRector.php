<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Expression;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\MethodCallToReturn;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\MethodCallToReturnRectorTest
 */
final class MethodCallToReturnRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_CALL_WRAPS = 'method_call_wraps';
    /**
     * @var MethodCallToReturn[]
     */
    private $methodCallWraps = [];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Wrap method call to return', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression::class];
    }
    /**
     * @param Expression $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        $methodCall = $node->expr;
        return $this->refactorMethodCall($methodCall);
    }
    public function configure(array $configuration) : void
    {
        $methodCallWraps = $configuration[self::METHOD_CALL_WRAPS] ?? [];
        \_PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert::allIsInstanceOf($methodCallWraps, \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\MethodCallToReturn::class);
        $this->methodCallWraps = $methodCallWraps;
    }
    private function refactorMethodCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        foreach ($this->methodCallWraps as $methodCallWrap) {
            if (!$this->isObjectType($methodCall->var, $methodCallWrap->getClass())) {
                continue;
            }
            if (!$this->isName($methodCall->name, $methodCallWrap->getMethod())) {
                continue;
            }
            $parentNode = $methodCall->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            // already wrapped
            if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_) {
                continue;
            }
            $return = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_($methodCall);
            $methodCall->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $return);
            return $return;
        }
        return null;
    }
}
