<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Rector\ConstFetch;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Renaming\Tests\Rector\ConstFetch\RenameConstantRector\RenameConstantRectorTest
 */
final class RenameConstantRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const OLD_TO_NEW_CONSTANTS = '$oldToNewConstants';
    /**
     * @var string[]
     */
    private $oldToNewConstants = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace constant by new ones', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        return MYSQL_ASSOC;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        return MYSQLI_ASSOC;
    }
}
CODE_SAMPLE
, [self::OLD_TO_NEW_CONSTANTS => ['MYSQL_ASSOC' => 'MYSQLI_ASSOC', 'OLD_CONSTANT' => 'NEW_CONSTANT']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch::class];
    }
    /**
     * @param ConstFetch $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->oldToNewConstants as $oldConstant => $newConstant) {
            if (!$this->isName($node, $oldConstant)) {
                continue;
            }
            $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($newConstant);
            break;
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->oldToNewConstants = $configuration[self::OLD_TO_NEW_CONSTANTS] ?? [];
    }
}
