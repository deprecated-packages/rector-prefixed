<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Transform\ValueObject\FuncCallToStaticCall;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210408\Webmozart\Assert\Assert;
/**
 * @see \Rector\Tests\Transform\Rector\FuncCall\FuncCallToStaticCallRector\FuncCallToStaticCallRectorTest
 */
final class FuncCallToStaticCallRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const FUNC_CALLS_TO_STATIC_CALLS = 'func_calls_to_static_calls';
    /**
     * @var FuncCallToStaticCall[]
     */
    private $funcCallsToStaticCalls = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined function call to static method call.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('view("...", []);', 'SomeClass::render("...", []);', [self::FUNC_CALLS_TO_STATIC_CALLS => [new \Rector\Transform\ValueObject\FuncCallToStaticCall('view', 'SomeStaticClass', 'render')]])]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->funcCallsToStaticCalls as $funcCallToStaticCall) {
            if (!$this->isName($node, $funcCallToStaticCall->getOldFuncName())) {
                continue;
            }
            return $this->nodeFactory->createStaticCall($funcCallToStaticCall->getNewClassName(), $funcCallToStaticCall->getNewMethodName(), $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $funcCallsToStaticCalls = $configuration[self::FUNC_CALLS_TO_STATIC_CALLS] ?? [];
        \RectorPrefix20210408\Webmozart\Assert\Assert::allIsInstanceOf($funcCallsToStaticCalls, \Rector\Transform\ValueObject\FuncCallToStaticCall::class);
        $this->funcCallsToStaticCalls = $funcCallsToStaticCalls;
    }
}
