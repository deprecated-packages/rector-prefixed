<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeAlreadyAddedChecker;

use Iterator;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\NullableType;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\PhpParser\Node\UnionType as PhpParserUnionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    public function isSameOrBetterReturnTypeAlreadyAdded(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $returnType) : bool
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
        if ($returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType && $returnType->getClassName() === 'class-string') {
            return \true;
        }
        // prevent overriding self with itself
        if (!$functionLike->returnType instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            return \false;
        }
        if ($functionLike->returnType->toLowerString() !== 'self') {
            return \false;
        }
        $className = $functionLike->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return \ltrim($this->betterStandardPrinter->printWithoutComments($returnNode), '\\') === $className;
    }
    /**
     * @param Identifier|Name|NullableType|PhpParserUnionType $returnTypeNode
     */
    private function isArrayIterableIteratorCoType(\_PhpScoper0a6b37af0871\PhpParser\Node $returnTypeNode, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $returnType) : bool
    {
        if (!$this->nodeNameResolver->isNames($returnTypeNode, self::FOREACHABLE_TYPES)) {
            return \false;
        }
        return $this->isStaticTypeIterable($returnType);
    }
    /**
     * @param Identifier|Name|NullableType|PhpParserUnionType $returnTypeNode
     */
    private function isUnionCoType(\_PhpScoper0a6b37af0871\PhpParser\Node $returnTypeNode, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            return \false;
        }
        // skip nullable type
        $nullType = new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
        if ($type->isSuperTypeOf($nullType)->yes()) {
            return \false;
        }
        $classMethodReturnType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($returnTypeNode);
        return $type->isSuperTypeOf($classMethodReturnType)->yes();
    }
    private function isStaticTypeIterable(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        if ($this->isArrayIterableOrIteratorType($type)) {
            return \true;
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
            foreach ($type->getTypes() as $joinedType) {
                if (!$this->isStaticTypeIterable($joinedType)) {
                    return \false;
                }
            }
            return \true;
        }
        return \false;
    }
    private function isArrayIterableOrIteratorType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
            return \true;
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType) {
            return \true;
        }
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $type->getClassName() === \Iterator::class;
    }
}
