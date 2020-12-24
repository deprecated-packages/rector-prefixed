<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\Include_;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Include_;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\MagicConst\Dir;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symplify/CodingStandard#includerequire-should-be-followed-by-absolute-path
 *
 * @see \Rector\CodeQuality\Tests\Rector\Include_\AbsolutizeRequireAndIncludePathRector\AbsolutizeRequireAndIncludePathRectorTest
 */
final class AbsolutizeRequireAndIncludePathRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('include/require to absolute path. This Rector might introduce backwards incompatible code, when the include/require beeing changed depends on the current working directory.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        require 'autoload.php';

        require $variable;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        require __DIR__ . '/autoload.php';

        require $variable;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Include_::class];
    }
    /**
     * @param Include_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return null;
        }
        /** @var string $includeValue */
        $includeValue = $this->getValue($node->expr);
        // skip phar
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::startsWith($includeValue, 'phar://')) {
            return null;
        }
        // add preslash to string
        // keep dots
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::startsWith($includeValue, '/') && !\_PhpScopere8e811afab72\Nette\Utils\Strings::startsWith($includeValue, '.')) {
            $node->expr->value = '/' . $includeValue;
        }
        $node->expr = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\MagicConst\Dir(), $node->expr);
        return $node;
    }
}
