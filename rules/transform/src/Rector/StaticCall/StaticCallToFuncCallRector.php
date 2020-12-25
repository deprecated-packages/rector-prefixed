<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\StaticCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Transform\ValueObject\StaticCallToFuncCall;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper8b9c402c5f32\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector\StaticCallToFuncCallRectorTest
 */
final class StaticCallToFuncCallRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const STATIC_CALLS_TO_FUNCTIONS = 'static_calls_to_functions';
    /**
     * @var StaticCallToFuncCall[]
     */
    private $staticCallsToFunctions = [];
    /**
     * @param StaticCallToFuncCall[] $staticCallToFunctions
     */
    public function __construct(array $staticCallToFunctions = [])
    {
        $this->staticCallsToFunctions = $staticCallToFunctions;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns static call to function call.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('OldClass::oldMethod("args");', 'new_function("args");', [self::STATIC_CALLS_TO_FUNCTIONS => [new \Rector\Transform\ValueObject\StaticCallToFuncCall('OldClass', 'oldMethod', 'new_function')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->staticCallsToFunctions as $staticCallsToFunctions) {
            if (!$this->isObjectType($node, $staticCallsToFunctions->getClass())) {
                continue;
            }
            if (!$this->isName($node->name, $staticCallsToFunctions->getMethod())) {
                continue;
            }
            return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name\FullyQualified($staticCallsToFunctions->getFunction()), $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $staticCallsToFunctions = $configuration[self::STATIC_CALLS_TO_FUNCTIONS] ?? [];
        \_PhpScoper8b9c402c5f32\Webmozart\Assert\Assert::allIsInstanceOf($staticCallsToFunctions, \Rector\Transform\ValueObject\StaticCallToFuncCall::class);
        $this->staticCallsToFunctions = $staticCallsToFunctions;
    }
}
