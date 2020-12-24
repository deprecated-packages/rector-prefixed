<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CakePHP\Rector\Property;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CakePHP\Tests\Rector\Property\ChangeSnakedFixtureNameToPascal\ChangeSnakedFixtureNameToPascalTest
 *
 * @see https://book.cakephp.org/3.0/en/appendices/3-7-migration-guide.html
 */
final class ChangeSnakedFixtureNameToPascalRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes $fixtues style from snake_case to PascalCase.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeTest
{
    protected $fixtures = [
        'app.posts',
        'app.users',
        'some_plugin.posts/special_posts',
    ];
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeTest
{
    protected $fixtures = [
        'app.Posts',
        'app.Users',
        'some_plugin.Posts/SpecialPosts',
    ];
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
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return null;
        }
        if (!$this->isName($node, 'fixtures')) {
            return null;
        }
        foreach ($node->props as $prop) {
            $this->refactorPropertyWithArrayDefault($prop);
        }
        return $node;
    }
    private function refactorPropertyWithArrayDefault(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\PropertyProperty $propertyProperty) : void
    {
        if (!$propertyProperty->default instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
            return;
        }
        $array = $propertyProperty->default;
        foreach ($array->items as $arrayItem) {
            if (!$arrayItem instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            if (!$arrayItem->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
                continue;
            }
            $this->renameFixtureName($arrayItem->value);
        }
    }
    private function renameFixtureName(\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_ $string) : void
    {
        [$prefix, $table] = \explode('.', $string->value);
        $table = \array_map(function (string $token) : string {
            return \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::underscoreToPascalCase($token);
        }, \explode('/', $table));
        $table = \implode('/', $table);
        $string->value = \sprintf('%s.%s', $prefix, $table);
    }
}
