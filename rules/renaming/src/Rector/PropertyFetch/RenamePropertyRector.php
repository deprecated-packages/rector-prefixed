<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\PropertyFetch;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\RenamePropertyRectorTest
 */
final class RenamePropertyRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const RENAMED_PROPERTIES = 'old_to_new_property_by_types';
    /**
     * @var RenameProperty[]
     */
    private $renamedProperties = [];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined old properties by new ones.', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('$someObject->someOldProperty;', '$someObject->someNewProperty;', [self::RENAMED_PROPERTIES => [new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameProperty('SomeClass', 'someOldProperty', 'someNewProperty')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch::class];
    }
    /**
     * @param PropertyFetch $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        foreach ($this->renamedProperties as $renamedProperty) {
            if (!$this->isObjectType($node->var, $renamedProperty->getType())) {
                continue;
            }
            if (!$this->isName($node, $renamedProperty->getOldProperty())) {
                continue;
            }
            $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($renamedProperty->getNewProperty());
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $renamedProperties = $configuration[self::RENAMED_PROPERTIES] ?? [];
        \_PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert::allIsInstanceOf($renamedProperties, \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameProperty::class);
        $this->renamedProperties = $renamedProperties;
    }
}
