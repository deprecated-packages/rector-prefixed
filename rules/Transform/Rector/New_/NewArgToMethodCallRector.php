<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\New_;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Transform\ValueObject\NewArgToMethodCall;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210408\Webmozart\Assert\Assert;
/**
 * @see https://github.com/symfony/symfony/pull/35308
 *
 * @see \Rector\Tests\Transform\Rector\New_\NewArgToMethodCallRector\NewArgToMethodCallRectorTest
 */
final class NewArgToMethodCallRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const NEW_ARGS_TO_METHOD_CALLS = 'new_args_to_method_calls';
    /**
     * @var NewArgToMethodCall[]
     */
    private $newArgsToMethodCalls = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change new with specific argument to method call', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $dotenv = new Dotenv(true);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $dotenv = new Dotenv();
        $dotenv->usePutenv();
    }
}
CODE_SAMPLE
, [self::NEW_ARGS_TO_METHOD_CALLS => [new \Rector\Transform\ValueObject\NewArgToMethodCall('Dotenv', \true, 'usePutenv')]])]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->newArgsToMethodCalls as $newArgToMethodCall) {
            if (!$this->isObjectType($node->class, $newArgToMethodCall->getObjectType())) {
                continue;
            }
            if (!isset($node->args[0])) {
                return null;
            }
            $firstArgValue = $node->args[0]->value;
            if (!$this->valueResolver->isValue($firstArgValue, $newArgToMethodCall->getValue())) {
                continue;
            }
            unset($node->args[0]);
            return new \PhpParser\Node\Expr\MethodCall($node, 'usePutenv');
        }
        return null;
    }
    /**
     * @param array<string, NewArgToMethodCall[]> $configuration
     */
    public function configure(array $configuration) : void
    {
        $newArgsToMethodCalls = $configuration[self::NEW_ARGS_TO_METHOD_CALLS] ?? [];
        \RectorPrefix20210408\Webmozart\Assert\Assert::allIsInstanceOf($newArgsToMethodCalls, \Rector\Transform\ValueObject\NewArgToMethodCall::class);
        $this->newArgsToMethodCalls = $newArgsToMethodCalls;
    }
}
