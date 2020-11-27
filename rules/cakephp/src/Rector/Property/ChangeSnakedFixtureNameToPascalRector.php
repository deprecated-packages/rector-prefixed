<?php

declare (strict_types=1);
namespace Rector\CakePHP\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Property;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\Util\StaticRectorStrings;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CakePHP\Tests\Rector\Property\ChangeSnakedFixtureNameToPascal\ChangeSnakedFixtureNameToPascalTest
 *
 * @see https://book.cakephp.org/3.0/en/appendices/3-7-migration-guide.html
 */
final class ChangeSnakedFixtureNameToPascalRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes $fixtues style from snake_case to PascalCase.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return null;
        }
        if (!$this->isName($node, 'fixtures')) {
            return null;
        }
        foreach ($node->props as $prop) {
            if (!$prop->default instanceof \PhpParser\Node\Expr\Array_) {
                continue;
            }
            foreach ($prop->default->items as $item) {
                if (!$item->value instanceof \PhpParser\Node\Scalar\String_) {
                    continue;
                }
                $this->renameFixtureName($item->value);
            }
        }
        return $node;
    }
    private function renameFixtureName(\PhpParser\Node\Scalar\String_ $string) : void
    {
        [$prefix, $table] = \explode('.', $string->value);
        $table = \array_map(function (string $token) : string {
            return \Rector\Core\Util\StaticRectorStrings::underscoreToPascalCase($token);
        }, \explode('/', $table));
        $table = \implode('/', $table);
        $string->value = \sprintf('%s.%s', $prefix, $table);
    }
}
