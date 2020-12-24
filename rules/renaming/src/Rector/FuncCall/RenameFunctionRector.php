<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Rector\FuncCall;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Renaming\Tests\Rector\FuncCall\RenameFunctionRector\RenameFunctionRectorTest
 */
final class RenameFunctionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const OLD_FUNCTION_TO_NEW_FUNCTION = '$oldFunctionToNewFunction';
    /**
     * @var array<string, string>
     */
    private $oldFunctionToNewFunction = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined function call new one.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('view("...", []);', 'Laravel\\Templating\\render("...", []);', [self::OLD_FUNCTION_TO_NEW_FUNCTION => ['view' => '_PhpScopere8e811afab72\\Laravel\\Templating\\render']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->oldFunctionToNewFunction as $oldFunction => $newFunction) {
            if (!$this->isName($node, $oldFunction)) {
                continue;
            }
            $node->name = \_PhpScopere8e811afab72\Nette\Utils\Strings::contains($newFunction, '\\') ? new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($newFunction) : new \_PhpScopere8e811afab72\PhpParser\Node\Name($newFunction);
        }
        return $node;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $this->oldFunctionToNewFunction = $configuration[self::OLD_FUNCTION_TO_NEW_FUNCTION] ?? [];
    }
}
