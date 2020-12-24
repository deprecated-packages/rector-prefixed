<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\UnionType;
final class PhpParserTypeAnalyzer
{
    /**
     * @param Name|NullableType|UnionType|Identifier $possibleSubtype
     * @param Name|NullableType|UnionType|Identifier $possibleParentType
     */
    public function isSubtypeOf(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $possibleSubtype, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $possibleParentType) : bool
    {
        // skip until PHP 8 is out
        if ($this->isUnionType($possibleSubtype, $possibleParentType)) {
            return \false;
        }
        // possible - https://3v4l.org/ZuJCh
        if ($possibleSubtype instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType && !$possibleParentType instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType) {
            return $this->isSubtypeOf($possibleSubtype->type, $possibleParentType);
        }
        // not possible - https://3v4l.org/iNDTc
        if (!$possibleSubtype instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType && $possibleParentType instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType) {
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
    private function isUnionType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $possibleSubtype, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $possibleParentType) : bool
    {
        if ($possibleSubtype instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\UnionType) {
            return \true;
        }
        return $possibleParentType instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\UnionType;
    }
    private function unwrapNullableAndToString(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : string
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType && \method_exists($node, 'toString')) {
            return $node->toString();
        }
        /** @var NullableType $type */
        $type = $node;
        return $type->type->toString();
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
