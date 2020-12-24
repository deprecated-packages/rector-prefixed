<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php73\Rector\String_;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/flexible_heredoc_nowdoc_syntaxes
 * @see \Rector\Php73\Tests\Rector\String_\SensitiveHereNowDocRector\SensitiveHereNowDocRectorTest
 */
final class SensitiveHereNowDocRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const WRAP_SUFFIX = '_WRAP';
    /**
     * @var string
     */
    private const ATTRIBUTE_DOC_LABEL = 'docLabel';
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes heredoc/nowdoc that contains closing word to safe wrapper name', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$value = <<<A
    A
A
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$value = <<<A_WRAP
    A
A_WRAP
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::class];
    }
    /**
     * @param String_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $kind = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::KIND);
        if (!\in_array($kind, [\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::KIND_HEREDOC, \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::KIND_NOWDOC], \true)) {
            return null;
        }
        // the doc label is not in the string → ok
        /** @var string $docLabel */
        $docLabel = $node->getAttribute(self::ATTRIBUTE_DOC_LABEL);
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($node->value, $docLabel)) {
            return null;
        }
        $node->setAttribute(self::ATTRIBUTE_DOC_LABEL, $this->uniquateDocLabel($node->value, $docLabel));
        // invoke redraw
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        return $node;
    }
    private function uniquateDocLabel(string $value, string $docLabel) : string
    {
        $docLabel .= self::WRAP_SUFFIX;
        $docLabelCounterTemplate = $docLabel . '_%d';
        $i = 0;
        while (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($value, $docLabel)) {
            $docLabel = \sprintf($docLabelCounterTemplate, ++$i);
        }
        return $docLabel;
    }
}
