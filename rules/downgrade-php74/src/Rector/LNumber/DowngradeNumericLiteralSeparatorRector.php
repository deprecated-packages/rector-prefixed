<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DowngradePhp74\Rector\LNumber;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\DNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/numeric_literal_separator
 * @see \Rector\DowngradePhp74\Tests\Rector\LNumber\DowngradeNumericLiteralSeparatorRector\DowngradeNumericLiteralSeparatorRectorTest
 */
final class DowngradeNumericLiteralSeparatorRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove "_" as thousands separator in numbers', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $int = 1_000;
        $float = 1_000_500.001;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $int = 1000;
        $float = 1000500.001;
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\DNumber::class];
    }
    /**
     * @param LNumber|DNumber $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->shouldRefactor($node)) {
            return null;
        }
        $node->value = (string) $node->value;
        /**
         * This code follows a guess, to avoid modifying floats needlessly.
         * If the node is a float, but it doesn't contain ".",
         * then it's likely that the number was forced to be a float
         * by adding ".0" at the end (eg: 0.0).
         * Then, add it again.
         */
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\DNumber && !\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($node->value, '.')) {
            $node->value .= '.0';
        }
        return $node;
    }
    /**
     * @param LNumber|DNumber $node
     */
    public function shouldRefactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        // "_" notation can be applied to decimal numbers only
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber) {
            return $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::KIND) === \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber::KIND_DEC;
        }
        return \true;
    }
}
