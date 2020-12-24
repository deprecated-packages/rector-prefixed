<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Rector\ClassConstFetch;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\ClassConstFetch\RenameClassConstantRector\RenameClassConstantRectorTest
 */
final class RenameClassConstantRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const CLASS_CONSTANT_RENAME = 'constant_rename';
    /**
     * @var RenameClassConstant[]
     */
    private $classConstantRenames = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $configuration = [self::CLASS_CONSTANT_RENAME => [new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant('SomeClass', 'OLD_CONSTANT', 'NEW_CONSTANT'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant('SomeClass', 'OTHER_OLD_CONSTANT', 'DifferentClass::NEW_CONSTANT')]];
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined class constants in their calls.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$value = SomeClass::OLD_CONSTANT;
$value = SomeClass::OTHER_OLD_CONSTANT;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$value = SomeClass::NEW_CONSTANT;
$value = DifferentClass::NEW_CONSTANT;
CODE_SAMPLE
, $configuration)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch::class];
    }
    /**
     * @param ClassConstFetch $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->classConstantRenames as $classConstantRename) {
            if (!$this->isObjectType($node, $classConstantRename->getOldClass())) {
                continue;
            }
            if (!$this->isName($node->name, $classConstantRename->getOldConstant())) {
                continue;
            }
            if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($classConstantRename->getNewConstant(), '::')) {
                return $this->createClassConstantFetchNodeFromDoubleColonFormat($classConstantRename->getNewConstant());
            }
            $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($classConstantRename->getNewConstant());
            return $node;
        }
        return $node;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $classConstantRenames = $configuration[self::CLASS_CONSTANT_RENAME] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($classConstantRenames, \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameClassConstant::class);
        $this->classConstantRenames = $classConstantRenames;
    }
    private function createClassConstantFetchNodeFromDoubleColonFormat(string $constant) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch
    {
        [$constantClass, $constantName] = \explode('::', $constant);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($constantClass), new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($constantName));
    }
}
