<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\PhpDocParser;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\CallableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VoidType;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\ParentStaticType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\SelfObjectType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType;
final class NonInformativeReturnTagRemover
{
    /**
     * @var string[][]
     */
    private const USELESS_DOC_NAMES_BY_TYPE_CLASS = [\_PhpScoper0a6b37af0871\PHPStan\Type\IterableType::class => ['iterable'], \_PhpScoper0a6b37af0871\PHPStan\Type\CallableType::class => ['callable'], \_PhpScoper0a6b37af0871\PHPStan\Type\VoidType::class => ['void'], \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType::class => ['array'], \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\SelfObjectType::class => ['self'], \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ParentStaticType::class => ['parent'], \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType::class => ['bool', 'boolean'], \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType::class => ['object']];
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    public function removeReturnTagIfNotUseful(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $returnTagValueNode = $phpDocInfo->getByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
        if ($returnTagValueNode === null) {
            return;
        }
        // useful
        if ($returnTagValueNode->description !== '') {
            return;
        }
        $returnType = $phpDocInfo->getReturnType();
        // is bare type
        if ($returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType || $returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType || $returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType) {
            $phpDocInfo->removeByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
            return;
        }
        $this->removeNonUniqueUselessDocNames($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeShortObjectType($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeNullableType($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeFullyQualifiedObjectType($returnType, $returnTagValueNode, $phpDocInfo);
    }
    private function removeNonUniqueUselessDocNames(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $returnType, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        foreach (self::USELESS_DOC_NAMES_BY_TYPE_CLASS as $typeClass => $uselessDocNames) {
            if (!\is_a($returnType, $typeClass, \true)) {
                continue;
            }
            if (!$this->isIdentifierWithValues($returnTagValueNode->type, $uselessDocNames)) {
                continue;
            }
            $phpDocInfo->removeByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
            return;
        }
    }
    private function removeShortObjectType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $returnType, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        if (!$returnType instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType) {
            return;
        }
        if (!$this->isIdentifierWithValues($returnTagValueNode->type, [$returnType->getShortName()])) {
            return;
        }
        $phpDocInfo->removeByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
    }
    private function removeNullableType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $returnType, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $nullabledReturnType = $this->matchNullabledType($returnType);
        if ($nullabledReturnType === null) {
            return;
        }
        $nullabledReturnTagValueNode = $this->matchNullabledReturnTagValueNode($returnTagValueNode);
        if ($nullabledReturnTagValueNode === null) {
            return;
        }
        if (!$nullabledReturnType instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return;
        }
        if (!$nullabledReturnTagValueNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return;
        }
        if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($nullabledReturnType->getClassName(), $nullabledReturnTagValueNode->name)) {
            return;
        }
        $phpDocInfo->removeByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
    }
    private function removeFullyQualifiedObjectType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $returnType, \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        if (!$returnType instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return;
        }
        if (!$returnTagValueNode->type instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return;
        }
        $className = $returnType->getClassName();
        $returnTagValueNodeType = (string) $returnTagValueNode->type;
        if ($this->isClassNameAndPartMatch($className, $returnTagValueNodeType)) {
            $phpDocInfo->removeByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
        }
    }
    /**
     * @param string[] $values
     */
    private function isIdentifierWithValues(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, array $values) : bool
    {
        if (!$typeNode instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return \false;
        }
        return \in_array($typeNode->name, $values, \true);
    }
    private function matchNullabledType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $returnType) : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (!$returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            return null;
        }
        if (!$returnType->isSuperTypeOf(new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType())->yes()) {
            return null;
        }
        if (\count($returnType->getTypes()) !== 2) {
            return null;
        }
        foreach ($returnType->getTypes() as $unionedReturnType) {
            if ($unionedReturnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NullType) {
                continue;
            }
            return $unionedReturnType;
        }
        return null;
    }
    private function matchNullabledReturnTagValueNode(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode) : ?\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if (!$returnTagValueNode->type instanceof \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return null;
        }
        if (\count((array) $returnTagValueNode->type->types) !== 2) {
            return null;
        }
        foreach ($returnTagValueNode->type->types as $unionedReturnTagValueNode) {
            if ($this->isIdentifierWithValues($unionedReturnTagValueNode, ['null'])) {
                continue;
            }
            return $unionedReturnTagValueNode;
        }
        return null;
    }
    private function isClassNameAndPartMatch(string $className, string $returnTagValueNodeType) : bool
    {
        if ($className === $returnTagValueNodeType) {
            return \true;
        }
        if ('\\' . $className === $returnTagValueNodeType) {
            return \true;
        }
        return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($className, '\\' . $returnTagValueNodeType);
    }
}
