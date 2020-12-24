<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php73\Rector\String_;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/flexible_heredoc_nowdoc_syntaxes
 * @see \Rector\Php73\Tests\Rector\String_\SensitiveHereNowDocRector\SensitiveHereNowDocRectorTest
 */
final class SensitiveHereNowDocRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const WRAP_SUFFIX = '_WRAP';
    /**
     * @var string
     */
    private const ATTRIBUTE_DOC_LABEL = 'docLabel';
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes heredoc/nowdoc that contains closing word to safe wrapper name', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_::class];
    }
    /**
     * @param String_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $kind = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::KIND);
        if (!\in_array($kind, [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_::KIND_HEREDOC, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_::KIND_NOWDOC], \true)) {
            return null;
        }
        // the doc label is not in the string → ok
        /** @var string $docLabel */
        $docLabel = $node->getAttribute(self::ATTRIBUTE_DOC_LABEL);
        if (!\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($node->value, $docLabel)) {
            return null;
        }
        $node->setAttribute(self::ATTRIBUTE_DOC_LABEL, $this->uniquateDocLabel($node->value, $docLabel));
        // invoke redraw
        $node->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        return $node;
    }
    private function uniquateDocLabel(string $value, string $docLabel) : string
    {
        $docLabel .= self::WRAP_SUFFIX;
        $docLabelCounterTemplate = $docLabel . '_%d';
        $i = 0;
        while (\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($value, $docLabel)) {
            $docLabel = \sprintf($docLabelCounterTemplate, ++$i);
        }
        return $docLabel;
    }
}
