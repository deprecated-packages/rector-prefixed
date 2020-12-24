<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToFuncCall;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector\StaticCallToFuncCallRectorTest
 */
final class StaticCallToFuncCallRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns static call to function call.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('OldClass::oldMethod("args");', 'new_function("args");', [self::STATIC_CALLS_TO_FUNCTIONS => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToFuncCall('OldClass', 'oldMethod', 'new_function')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach ($this->staticCallsToFunctions as $staticCallsToFunctions) {
            if (!$this->isObjectType($node, $staticCallsToFunctions->getClass())) {
                continue;
            }
            if (!$this->isName($node->name, $staticCallsToFunctions->getMethod())) {
                continue;
            }
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($staticCallsToFunctions->getFunction()), $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $staticCallsToFunctions = $configuration[self::STATIC_CALLS_TO_FUNCTIONS] ?? [];
        \_PhpScoper0a6b37af0871\Webmozart\Assert\Assert::allIsInstanceOf($staticCallsToFunctions, \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToFuncCall::class);
        $this->staticCallsToFunctions = $staticCallsToFunctions;
    }
}
