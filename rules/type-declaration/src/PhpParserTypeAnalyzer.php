<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\NullableType;
use _PhpScoper0a2ac50786fa\PhpParser\Node\UnionType;
final class PhpParserTypeAnalyzer
{
    /**
     * @param Name|NullableType|UnionType|Identifier $possibleSubtype
     * @param Name|NullableType|UnionType|Identifier $possibleParentType
     */
    public function isSubtypeOf(\_PhpScoper0a2ac50786fa\PhpParser\Node $possibleSubtype, \_PhpScoper0a2ac50786fa\PhpParser\Node $possibleParentType) : bool
    {
        // skip until PHP 8 is out
        if ($possibleSubtype instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\UnionType || $possibleParentType instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\UnionType) {
            return \false;
        }
        // possible - https://3v4l.org/ZuJCh
        if ($possibleSubtype instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\NullableType && !$possibleParentType instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\NullableType) {
            return $this->isSubtypeOf($possibleSubtype->type, $possibleParentType);
        }
        // not possible - https://3v4l.org/iNDTc
        if (!$possibleSubtype instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\NullableType && $possibleParentType instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\NullableType) {
            return \false;
        }
        // unwrap nullable types
        $possibleParentType = $this->unwrapNullableAndToString($possibleParentType);
        $possibleSubtype = $this->unwrapNullableAndToString($possibleSubtype);
        if (\is_a($possibleSubtype, $possibleParentType, \true)) {
            return \true;
        }
        if ($this->isTraversableOrIterableSubtype($possibleSubtype, $possibleParentType)) {
            return \true;
        }
        if ($possibleParentType === $possibleSubtype) {
            return \true;
        }
        if (!\ctype_upper($possibleSubtype[0])) {
            return \false;
        }
        return $possibleParentType === 'object';
    }
    /**
     * @param Name|NullableType|Identifier $node
     */
    private function unwrapNullableAndToString(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : string
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\NullableType) {
            return $node->toString();
        }
        return $node->type->toString();
    }
    private function isTraversableOrIterableSubtype(string $possibleSubtype, string $possibleParentType) : bool
    {
        if (\in_array($possibleSubtype, ['array', 'Traversable'], \true) && $possibleParentType === 'iterable') {
            return \true;
        }
        if (!\in_array($possibleSubtype, ['array', 'ArrayIterator'], \true)) {
            return \false;
        }
        return $possibleParentType === 'countable';
    }
}
