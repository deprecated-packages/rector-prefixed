<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Rector\StaticCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToFuncCall;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector\StaticCallToFuncCallRectorTest
 */
final class StaticCallToFuncCallRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns static call to function call.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('OldClass::oldMethod("args");', 'new_function("args");', [self::STATIC_CALLS_TO_FUNCTIONS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToFuncCall('OldClass', 'oldMethod', 'new_function')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($this->staticCallsToFunctions as $staticCallsToFunctions) {
            if (!$this->isObjectType($node, $staticCallsToFunctions->getClass())) {
                continue;
            }
            if (!$this->isName($node->name, $staticCallsToFunctions->getMethod())) {
                continue;
            }
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($staticCallsToFunctions->getFunction()), $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $staticCallsToFunctions = $configuration[self::STATIC_CALLS_TO_FUNCTIONS] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($staticCallsToFunctions, \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToFuncCall::class);
        $this->staticCallsToFunctions = $staticCallsToFunctions;
    }
}
