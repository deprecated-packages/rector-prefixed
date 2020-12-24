<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeAlreadyAddedChecker;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\PhpParser\Node\UnionType as PhpParserUnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    public function isSameOrBetterReturnTypeAlreadyAdded(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType) : bool
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
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType && $returnType->getClassName() === 'class-string') {
            return \true;
        }
        // prevent overriding self with itself
        if (!$functionLike->returnType instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return \false;
        }
        if ($functionLike->returnType->toLowerString() !== 'self') {
            return \false;
        }
        $className = $functionLike->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return \ltrim($this->betterStandardPrinter->printWithoutComments($returnNode), '\\') === $className;
    }
    /**
     * @param Identifier|Name|NullableType|PhpParserUnionType $returnTypeNode
     */
    private function isArrayIterableIteratorCoType(\_PhpScoperb75b35f52b74\PhpParser\Node $returnTypeNode, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType) : bool
    {
        if (!$this->nodeNameResolver->isNames($returnTypeNode, self::FOREACHABLE_TYPES)) {
            return \false;
        }
        return $this->isStaticTypeIterable($returnType);
    }
    /**
     * @param Identifier|Name|NullableType|PhpParserUnionType $returnTypeNode
     */
    private function isUnionCoType(\_PhpScoperb75b35f52b74\PhpParser\Node $returnTypeNode, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return \false;
        }
        // skip nullable type
        $nullType = new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
        if ($type->isSuperTypeOf($nullType)->yes()) {
            return \false;
        }
        $classMethodReturnType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($returnTypeNode);
        return $type->isSuperTypeOf($classMethodReturnType)->yes();
    }
    private function isStaticTypeIterable(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if ($this->isArrayIterableOrIteratorType($type)) {
            return \true;
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType || $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            foreach ($type->getTypes() as $joinedType) {
                if (!$this->isStaticTypeIterable($joinedType)) {
                    return \false;
                }
            }
            return \true;
        }
        return \false;
    }
    private function isArrayIterableOrIteratorType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return \true;
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType) {
            return \true;
        }
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $type->getClassName() === \Iterator::class;
    }
}
