<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Rector\PropertyFetch;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\RenamePropertyRectorTest
 */
final class RenamePropertyRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const RENAMED_PROPERTIES = 'old_to_new_property_by_types';
    /**
     * @var RenameProperty[]
     */
    private $renamedProperties = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined old properties by new ones.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('$someObject->someOldProperty;', '$someObject->someNewProperty;', [self::RENAMED_PROPERTIES => [new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameProperty('SomeClass', 'someOldProperty', 'someNewProperty')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch::class];
    }
    /**
     * @param PropertyFetch $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($this->renamedProperties as $renamedProperty) {
            if (!$this->isObjectType($node->var, $renamedProperty->getType())) {
                continue;
            }
            if (!$this->isName($node, $renamedProperty->getOldProperty())) {
                continue;
            }
            $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($renamedProperty->getNewProperty());
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $renamedProperties = $configuration[self::RENAMED_PROPERTIES] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($renamedProperties, \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameProperty::class);
        $this->renamedProperties = $renamedProperties;
    }
}
