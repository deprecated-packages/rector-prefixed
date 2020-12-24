<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
final class PhpParserTypeAnalyzer
{
    /**
     * @param Name|NullableType|UnionType|Identifier $possibleSubtype
     * @param Name|NullableType|UnionType|Identifier $possibleParentType
     */
    public function isSubtypeOf(\_PhpScopere8e811afab72\PhpParser\Node $possibleSubtype, \_PhpScopere8e811afab72\PhpParser\Node $possibleParentType) : bool
    {
        // skip until PHP 8 is out
        if ($possibleSubtype instanceof \_PhpScopere8e811afab72\PhpParser\Node\UnionType || $possibleParentType instanceof \_PhpScopere8e811afab72\PhpParser\Node\UnionType) {
            return \false;
        }
        // possible - https://3v4l.org/ZuJCh
        if ($possibleSubtype instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType && !$possibleParentType instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
            return $this->isSubtypeOf($possibleSubtype->type, $possibleParentType);
        }
        // not possible - https://3v4l.org/iNDTc
        if (!$possibleSubtype instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType && $possibleParentType instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
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
    private function unwrapNullableAndToString(\_PhpScopere8e811afab72\PhpParser\Node $node) : string
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
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
