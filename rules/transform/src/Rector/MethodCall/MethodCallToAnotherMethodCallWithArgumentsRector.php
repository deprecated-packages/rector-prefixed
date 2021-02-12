<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use Rector\Transform\ValueObject\MethodCallToAnotherMethodCallWithArguments;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210212\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector\MethodCallToAnotherMethodCallWithArgumentsRectorTest
 */
final class MethodCallToAnotherMethodCallWithArgumentsRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_CALL_RENAMES_WITH_ADDED_ARGUMENTS = 'method_call_renames_with_added_arguments';
    /**
     * @var MethodCallToAnotherMethodCallWithArguments[]
     */
    private $methodCallRenamesWithAddedArguments = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns old method call with specific types to new one with arguments', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$serviceDefinition = new Nette\DI\ServiceDefinition;
$serviceDefinition->setInject();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$serviceDefinition = new Nette\DI\ServiceDefinition;
$serviceDefinition->addTag('inject');
CODE_SAMPLE
, [self::METHOD_CALL_RENAMES_WITH_ADDED_ARGUMENTS => [new \Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey('Nette\\DI\\ServiceDefinition', 'setInject', 'addTag', 'inject')]])]);
    }
    /**
     * @return string[]
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
        foreach ($this->methodCallRenamesWithAddedArguments as $methodCallRenamedWithAddedArgument) {
            if (!$this->isObjectType($node, $methodCallRenamedWithAddedArgument->getType())) {
                continue;
            }
            if (!$this->isName($node->name, $methodCallRenamedWithAddedArgument->getOldMethod())) {
                continue;
            }
            $node->name = new \PhpParser\Node\Identifier($methodCallRenamedWithAddedArgument->getNewMethod());
            $node->args = $this->nodeFactory->createArgs($methodCallRenamedWithAddedArgument->getNewArguments());
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $methodCallRenamesWithAddedArguments = $configuration[self::METHOD_CALL_RENAMES_WITH_ADDED_ARGUMENTS] ?? [];
        \RectorPrefix20210212\Webmozart\Assert\Assert::allIsInstanceOf($methodCallRenamesWithAddedArguments, \Rector\Transform\ValueObject\MethodCallToAnotherMethodCallWithArguments::class);
        $this->methodCallRenamesWithAddedArguments = $methodCallRenamesWithAddedArguments;
    }
}
