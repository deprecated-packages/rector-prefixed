<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Rector\Property;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver;
use _PhpScopere8e811afab72\Rector\Naming\PropertyRenamer\UnderscoreCamelCasePropertyRenamer;
use _PhpScopere8e811afab72\Rector\Naming\ValueObjectFactory\PropertyRenameFactory;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\Property\UnderscoreToCamelCasePropertyNameRector\UnderscoreToCamelCasePropertyNameRectorTest
 */
final class UnderscoreToCamelCasePropertyNameRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyRenameFactory
     */
    private $propertyRenameFactory;
    /**
     * @var UnderscoreCamelCasePropertyRenamer
     */
    private $underscoreCamelCasePropertyRenamer;
    /**
     * @var UnderscoreCamelCaseExpectedNameResolver
     */
    private $underscoreCamelCaseExpectedNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\PropertyRenamer\UnderscoreCamelCasePropertyRenamer $underscoreCamelCasePropertyRenamer, \_PhpScopere8e811afab72\Rector\Naming\ValueObjectFactory\PropertyRenameFactory $propertyRenameFactory, \_PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver $underscoreCamelCaseExpectedNameResolver)
    {
        $this->underscoreCamelCasePropertyRenamer = $underscoreCamelCasePropertyRenamer;
        $this->propertyRenameFactory = $propertyRenameFactory;
        $this->underscoreCamelCaseExpectedNameResolver = $underscoreCamelCaseExpectedNameResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change under_score names to camelCase', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public $property_name;

    public function run($a)
    {
        $this->property_name = 5;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public $propertyName;

    public function run($a)
    {
        $this->propertyName = 5;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $propertyName = $this->getName($node);
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($propertyName, '_')) {
            return null;
        }
        $propertyRename = $this->propertyRenameFactory->create($node, $this->underscoreCamelCaseExpectedNameResolver);
        if ($propertyRename === null) {
            return null;
        }
        $property = $this->underscoreCamelCasePropertyRenamer->rename($propertyRename);
        if ($property === null) {
            return null;
        }
        return $node;
    }
}
