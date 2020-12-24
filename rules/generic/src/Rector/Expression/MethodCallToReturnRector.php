<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Rector\Expression;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\MethodCallToReturn;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\MethodCallToReturnRectorTest
 */
final class MethodCallToReturnRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_CALL_WRAPS = 'method_call_wraps';
    /**
     * @var MethodCallToReturn[]
     */
    private $methodCallWraps = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Wrap method call to return', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression::class];
    }
    /**
     * @param Expression $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        $methodCall = $node->expr;
        return $this->refactorMethodCall($methodCall);
    }
    public function configure(array $configuration) : void
    {
        $methodCallWraps = $configuration[self::METHOD_CALL_WRAPS] ?? [];
        \_PhpScoper0a6b37af0871\Webmozart\Assert\Assert::allIsInstanceOf($methodCallWraps, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\MethodCallToReturn::class);
        $this->methodCallWraps = $methodCallWraps;
    }
    private function refactorMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach ($this->methodCallWraps as $methodCallWrap) {
            if (!$this->isObjectType($methodCall->var, $methodCallWrap->getClass())) {
                continue;
            }
            if (!$this->isName($methodCall->name, $methodCallWrap->getMethod())) {
                continue;
            }
            $parentNode = $methodCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            // already wrapped
            if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_) {
                continue;
            }
            $return = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_($methodCall);
            $methodCall->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $return);
            return $return;
        }
        return null;
    }
}
