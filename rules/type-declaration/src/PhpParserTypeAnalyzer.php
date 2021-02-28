<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\UnionType;
use Rector\NodeNameResolver\NodeNameResolver;
final class PhpParserTypeAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Name|NullableType|UnionType|Identifier $possibleSubtype
     * @param Name|NullableType|UnionType|Identifier $possibleParentType
     */
    public function isSubtypeOf(\PhpParser\Node $possibleSubtype, \PhpParser\Node $possibleParentType) : bool
    {
        // skip until PHP 8 is out
        if ($this->isUnionType($possibleSubtype, $possibleParentType)) {
            return \false;
        }
        // possible - https://3v4l.org/ZuJCh
        if ($possibleSubtype instanceof \PhpParser\Node\NullableType && !$possibleParentType instanceof \PhpParser\Node\NullableType) {
            return $this->isSubtypeOf($possibleSubtype->type, $possibleParentType);
        }
        // not possible - https://3v4l.org/iNDTc
        if (!$possibleSubtype instanceof \PhpParser\Node\NullableType && $possibleParentType instanceof \PhpParser\Node\NullableType) {
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
    private function isUnionType(\PhpParser\Node $possibleSubtype, \PhpParser\Node $possibleParentType) : bool
    {
        if ($possibleSubtype instanceof \PhpParser\Node\UnionType) {
            return \true;
        }
        return $possibleParentType instanceof \PhpParser\Node\UnionType;
    }
    private function unwrapNullableAndToString(\PhpParser\Node $node) : string
    {
        if (!$node instanceof \PhpParser\Node\NullableType) {
            return $this->nodeNameResolver->getName($node);
        }
        return $this->nodeNameResolver->getName($node->type);
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
