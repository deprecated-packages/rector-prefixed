<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeAlreadyAddedChecker;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType as PhpParserUnionType;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
final class ReturnTypeAlreadyAddedChecker
{
    /**
     * @var string[]
     */
    private const FOREACHABLE_TYPES = ['iterable', 'Iterator', 'Traversable', 'array'];
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    public function isSameOrBetterReturnTypeAlreadyAdded(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike, \_PhpScopere8e811afab72\PHPStan\Type\Type $returnType) : bool
    {
        $nodeReturnType = $functionLike->returnType;
        /** @param Identifier|Name|NullableType|PhpParserUnionType|null $returnTypeNode */
        if ($nodeReturnType === null) {
            return \false;
        }
        $returnNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($returnType);
        if ($this->betterStandardPrinter->areNodesEqual($nodeReturnType, $returnNode)) {
            return \true;
        }
        // is array <=> iterable <=> Iterator co-type? → skip
        if ($this->isArrayIterableIteratorCoType($nodeReturnType, $returnType)) {
            return \true;
        }
        if ($this->isUnionCoType($nodeReturnType, $returnType)) {
            return \true;
        }
        // is class-string<T> type? → skip
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType && $returnType->getClassName() === 'class-string') {
            return \true;
        }
        // prevent overriding self with itself
        if (!$functionLike->returnType instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return \false;
        }
        if ($functionLike->returnType->toLowerString() !== 'self') {
            return \false;
        }
        $className = $functionLike->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return \ltrim($this->betterStandardPrinter->printWithoutComments($returnNode), '\\') === $className;
    }
    /**
     * @param Identifier|Name|NullableType|PhpParserUnionType $returnTypeNode
     */
    private function isArrayIterableIteratorCoType(\_PhpScopere8e811afab72\PhpParser\Node $returnTypeNode, \_PhpScopere8e811afab72\PHPStan\Type\Type $returnType) : bool
    {
        if (!$this->nodeNameResolver->isNames($returnTypeNode, self::FOREACHABLE_TYPES)) {
            return \false;
        }
        return $this->isStaticTypeIterable($returnType);
    }
    /**
     * @param Identifier|Name|NullableType|PhpParserUnionType $returnTypeNode
     */
    private function isUnionCoType(\_PhpScopere8e811afab72\PhpParser\Node $returnTypeNode, \_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return \false;
        }
        // skip nullable type
        $nullType = new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
        if ($type->isSuperTypeOf($nullType)->yes()) {
            return \false;
        }
        $classMethodReturnType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($returnTypeNode);
        return $type->isSuperTypeOf($classMethodReturnType)->yes();
    }
    private function isStaticTypeIterable(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if ($this->isArrayIterableOrIteratorType($type)) {
            return \true;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            foreach ($type->getTypes() as $joinedType) {
                if (!$this->isStaticTypeIterable($joinedType)) {
                    return \false;
                }
            }
            return \true;
        }
        return \false;
    }
    private function isArrayIterableOrIteratorType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            return \true;
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IterableType) {
            return \true;
        }
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $type->getClassName() === \Iterator::class;
    }
}
