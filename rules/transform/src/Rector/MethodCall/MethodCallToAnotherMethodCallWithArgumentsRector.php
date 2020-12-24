<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\MethodCallToAnotherMethodCallWithArguments;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\MethodCall\MethodCallToAnotherMethodCallWithArgumentsRector\MethodCallToAnotherMethodCallWithArgumentsRectorTest
 */
final class MethodCallToAnotherMethodCallWithArgumentsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_CALL_RENAMES_WITH_ADDED_ARGUMENTS = 'method_call_renames_with_added_arguments';
    /**
     * @var MethodCallToAnotherMethodCallWithArguments[]
     */
    private $methodCallRenamesWithAddedArguments = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns old method call with specific types to new one with arguments', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$serviceDefinition = new Nette\DI\ServiceDefinition;
$serviceDefinition->setInject();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$serviceDefinition = new Nette\DI\ServiceDefinition;
$serviceDefinition->addTag('inject');
CODE_SAMPLE
, [self::METHOD_CALL_RENAMES_WITH_ADDED_ARGUMENTS => [new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey('_PhpScopere8e811afab72\\Nette\\DI\\ServiceDefinition', 'setInject', 'addTag', 'inject')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->methodCallRenamesWithAddedArguments as $methodCallRenamedWithAddedArgument) {
            if (!$this->isObjectType($node, $methodCallRenamedWithAddedArgument->getType())) {
                continue;
            }
            if (!$this->isName($node->name, $methodCallRenamedWithAddedArgument->getOldMethod())) {
                continue;
            }
            $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($methodCallRenamedWithAddedArgument->getNewMethod());
            $node->args = $this->createArgs($methodCallRenamedWithAddedArgument->getNewArguments());
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $methodCallRenamesWithAddedArguments = $configuration[self::METHOD_CALL_RENAMES_WITH_ADDED_ARGUMENTS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($methodCallRenamesWithAddedArguments, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\MethodCallToAnotherMethodCallWithArguments::class);
        $this->methodCallRenamesWithAddedArguments = $methodCallRenamesWithAddedArguments;
    }
}
