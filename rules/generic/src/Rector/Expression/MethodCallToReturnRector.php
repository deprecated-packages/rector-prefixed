<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Rector\Expression;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\MethodCallToReturn;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\Expression\MethodCallToReturnRector\MethodCallToReturnRectorTest
 */
final class MethodCallToReturnRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_CALL_WRAPS = 'method_call_wraps';
    /**
     * @var MethodCallToReturn[]
     */
    private $methodCallWraps = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Wrap method call to return', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression::class];
    }
    /**
     * @param Expression $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        $methodCall = $node->expr;
        return $this->refactorMethodCall($methodCall);
    }
    public function configure(array $configuration) : void
    {
        $methodCallWraps = $configuration[self::METHOD_CALL_WRAPS] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($methodCallWraps, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\MethodCallToReturn::class);
        $this->methodCallWraps = $methodCallWraps;
    }
    private function refactorMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($this->methodCallWraps as $methodCallWrap) {
            if (!$this->isObjectType($methodCall->var, $methodCallWrap->getClass())) {
                continue;
            }
            if (!$this->isName($methodCall->name, $methodCallWrap->getMethod())) {
                continue;
            }
            $parentNode = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            // already wrapped
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
                continue;
            }
            $return = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($methodCall);
            $methodCall->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $return);
            return $return;
        }
        return null;
    }
}
