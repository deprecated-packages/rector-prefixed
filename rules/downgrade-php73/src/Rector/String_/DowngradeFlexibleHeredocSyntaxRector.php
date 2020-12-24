<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp73\Rector\String_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\Encapsed;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp73\Tests\Rector\String_\DowngradeFlexibleHeredocSyntaxRector\DowngradeFlexibleHeredocSyntaxTest
 */
final class DowngradeFlexibleHeredocSyntaxRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var int[]
     */
    private const HERENOW_DOC_KINDS = [\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::KIND_HEREDOC, \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::KIND_NOWDOC];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes heredoc/nowdoc that contains closing word to safe wrapper name', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$query = <<<SQL
    SELECT *
    FROM `table`
    WHERE `column` = true;
    SQL;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$query = <<<SQL
SELECT *
FROM `table`
WHERE `column` = true;
SQL;
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::class, \_PhpScopere8e811afab72\PhpParser\Node\Scalar\Encapsed::class];
    }
    /**
     * @param Encapsed|String_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $stringKind = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::KIND);
        if (!\in_array($stringKind, self::HERENOW_DOC_KINDS, \true)) {
            return null;
        }
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::DOC_INDENTATION, '');
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        return $node;
    }
}
