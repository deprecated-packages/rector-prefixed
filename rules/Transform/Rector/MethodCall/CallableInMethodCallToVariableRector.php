<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PHPStan\Type\ClosureType;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Transform\NodeFactory\UnwrapClosureFactory;
use Rector\Transform\ValueObject\CallableInMethodCallToVariable;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210408\Webmozart\Assert\Assert;
/**
 * @see https://github.com/nette/caching/commit/5ffe263752af5ccf3866a28305e7b2669ab4da82
 *
 * @see \Rector\Tests\Transform\Rector\MethodCall\CallableInMethodCallToVariableRector\CallableInMethodCallToVariableRectorTest
 */
final class CallableInMethodCallToVariableRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CALLABLE_IN_METHOD_CALL_TO_VARIABLE = 'callable_in_method_call_to_variable';
    /**
     * @var CallableInMethodCallToVariable[]
     */
    private $callableInMethodCallToVariable = [];
    /**
     * @var UnwrapClosureFactory
     */
    private $unwrapClosureFactory;
    public function __construct(\Rector\Transform\NodeFactory\UnwrapClosureFactory $unwrapClosureFactory)
    {
        $this->unwrapClosureFactory = $unwrapClosureFactory;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change a callable in method call to standalone variable assign', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        /** @var \Nette\Caching\Cache $cache */
        $cache->save($key, function () use ($container) {
            return 100;
        });
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        /** @var \Nette\Caching\Cache $cache */
        $result = 100;
        $cache->save($key, $result);
    }
}
CODE_SAMPLE
, [self::CALLABLE_IN_METHOD_CALL_TO_VARIABLE => [new \Rector\Transform\ValueObject\CallableInMethodCallToVariable('Nette\\Caching\\Cache', 'save', 1)]])]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->callableInMethodCallToVariable as $singleCallableInMethodCallToVariable) {
            if (!$this->isObjectType($node->var, $singleCallableInMethodCallToVariable->getObjectType())) {
                continue;
            }
            if (!isset($node->args[$singleCallableInMethodCallToVariable->getArgumentPosition()])) {
                continue;
            }
            $arg = $node->args[$singleCallableInMethodCallToVariable->getArgumentPosition()];
            $argValueType = $this->getStaticType($arg->value);
            if (!$argValueType instanceof \PHPStan\Type\ClosureType) {
                continue;
            }
            $resultVariable = new \PhpParser\Node\Expr\Variable('result');
            $unwrappedNodes = $this->unwrapClosureFactory->createAssign($resultVariable, $arg);
            $arg->value = $resultVariable;
            $this->addNodesBeforeNode($unwrappedNodes, $node);
            return $node;
        }
        return null;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $callableInMethodCallToVariable = $configuration[self::CALLABLE_IN_METHOD_CALL_TO_VARIABLE] ?? [];
        \RectorPrefix20210408\Webmozart\Assert\Assert::allIsInstanceOf($callableInMethodCallToVariable, \Rector\Transform\ValueObject\CallableInMethodCallToVariable::class);
        $this->callableInMethodCallToVariable = $callableInMethodCallToVariable;
    }
}
