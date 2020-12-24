<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\RenamePropertyRectorTest
 */
final class RenamePropertyRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const RENAMED_PROPERTIES = 'old_to_new_property_by_types';
    /**
     * @var RenameProperty[]
     */
    private $renamedProperties = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined old properties by new ones.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('$someObject->someOldProperty;', '$someObject->someNewProperty;', [self::RENAMED_PROPERTIES => [new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty('SomeClass', 'someOldProperty', 'someNewProperty')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch::class];
    }
    /**
     * @param PropertyFetch $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->renamedProperties as $renamedProperty) {
            if (!$this->isObjectType($node->var, $renamedProperty->getType())) {
                continue;
            }
            if (!$this->isName($node, $renamedProperty->getOldProperty())) {
                continue;
            }
            $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($renamedProperty->getNewProperty());
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $renamedProperties = $configuration[self::RENAMED_PROPERTIES] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($renamedProperties, \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty::class);
        $this->renamedProperties = $renamedProperties;
    }
}
