<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\PhpDocParser;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\CallableType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\ParentStaticType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\SelfObjectType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType;
final class NonInformativeReturnTagRemover
{
    /**
     * @var string[][]
     */
    private const USELESS_DOC_NAMES_BY_TYPE_CLASS = [\_PhpScopere8e811afab72\PHPStan\Type\IterableType::class => ['iterable'], \_PhpScopere8e811afab72\PHPStan\Type\CallableType::class => ['callable'], \_PhpScopere8e811afab72\PHPStan\Type\VoidType::class => ['void'], \_PhpScopere8e811afab72\PHPStan\Type\ArrayType::class => ['array'], \_PhpScopere8e811afab72\Rector\PHPStan\Type\SelfObjectType::class => ['self'], \_PhpScopere8e811afab72\Rector\PHPStan\Type\ParentStaticType::class => ['parent'], \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class => ['bool', 'boolean'], \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType::class => ['object']];
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    public function removeReturnTagIfNotUseful(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $returnTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
        if ($returnTagValueNode === null) {
            return;
        }
        // useful
        if ($returnTagValueNode->description !== '') {
            return;
        }
        $returnType = $phpDocInfo->getReturnType();
        // is bare type
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\FloatType || $returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\StringType || $returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerType) {
            $phpDocInfo->removeByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
            return;
        }
        $this->removeNonUniqueUselessDocNames($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeShortObjectType($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeNullableType($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeFullyQualifiedObjectType($returnType, $returnTagValueNode, $phpDocInfo);
    }
    private function removeNonUniqueUselessDocNames(\_PhpScopere8e811afab72\PHPStan\Type\Type $returnType, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        foreach (self::USELESS_DOC_NAMES_BY_TYPE_CLASS as $typeClass => $uselessDocNames) {
            if (!\is_a($returnType, $typeClass, \true)) {
                continue;
            }
            if (!$this->isIdentifierWithValues($returnTagValueNode->type, $uselessDocNames)) {
                continue;
            }
            $phpDocInfo->removeByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
            return;
        }
    }
    private function removeShortObjectType(\_PhpScopere8e811afab72\PHPStan\Type\Type $returnType, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        if (!$returnType instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType) {
            return;
        }
        if (!$this->isIdentifierWithValues($returnTagValueNode->type, [$returnType->getShortName()])) {
            return;
        }
        $phpDocInfo->removeByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
    }
    private function removeNullableType(\_PhpScopere8e811afab72\PHPStan\Type\Type $returnType, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $nullabledReturnType = $this->matchNullabledType($returnType);
        if ($nullabledReturnType === null) {
            return;
        }
        $nullabledReturnTagValueNode = $this->matchNullabledReturnTagValueNode($returnTagValueNode);
        if ($nullabledReturnTagValueNode === null) {
            return;
        }
        if (!$nullabledReturnType instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return;
        }
        if (!$nullabledReturnTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return;
        }
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($nullabledReturnType->getClassName(), $nullabledReturnTagValueNode->name)) {
            return;
        }
        $phpDocInfo->removeByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
    }
    private function removeFullyQualifiedObjectType(\_PhpScopere8e811afab72\PHPStan\Type\Type $returnType, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        if (!$returnType instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return;
        }
        if (!$returnTagValueNode->type instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return;
        }
        $className = $returnType->getClassName();
        $returnTagValueNodeType = (string) $returnTagValueNode->type;
        if ($this->isClassNameAndPartMatch($className, $returnTagValueNodeType)) {
            $phpDocInfo->removeByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
        }
    }
    /**
     * @param string[] $values
     */
    private function isIdentifierWithValues(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, array $values) : bool
    {
        if (!$typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return \false;
        }
        return \in_array($typeNode->name, $values, \true);
    }
    private function matchNullabledType(\_PhpScopere8e811afab72\PHPStan\Type\Type $returnType) : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return null;
        }
        if (!$returnType->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\NullType())->yes()) {
            return null;
        }
        if (\count($returnType->getTypes()) !== 2) {
            return null;
        }
        foreach ($returnType->getTypes() as $unionedReturnType) {
            if ($unionedReturnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NullType) {
                continue;
            }
            return $unionedReturnType;
        }
        return null;
    }
    private function matchNullabledReturnTagValueNode(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if (!$returnTagValueNode->type instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
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
        return \_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($className, '\\' . $returnTagValueNodeType);
    }
}
