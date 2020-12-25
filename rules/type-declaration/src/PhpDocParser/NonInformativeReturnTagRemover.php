<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\PhpDocParser;

use _PhpScoper5edc98a7cce2\Nette\Utils\Strings;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\CallableType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IterableType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VoidType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\ParentStaticType;
use Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
final class NonInformativeReturnTagRemover
{
    /**
     * @var string[][]
     */
    private const USELESS_DOC_NAMES_BY_TYPE_CLASS = [\PHPStan\Type\IterableType::class => ['iterable'], \PHPStan\Type\CallableType::class => ['callable'], \PHPStan\Type\VoidType::class => ['void'], \PHPStan\Type\ArrayType::class => ['array'], \Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType::class => ['self'], \Rector\StaticTypeMapper\ValueObject\Type\ParentStaticType::class => ['parent'], \PHPStan\Type\BooleanType::class => ['bool', 'boolean'], \PHPStan\Type\ObjectWithoutClassType::class => ['object']];
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    public function removeReturnTagIfNotUseful(\PhpParser\Node\FunctionLike $functionLike) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $returnTagValueNode = $phpDocInfo->getByType(\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
        if ($returnTagValueNode === null) {
            return;
        }
        // useful
        if ($returnTagValueNode->description !== '') {
            return;
        }
        $returnType = $phpDocInfo->getReturnType();
        // is bare type
        if ($returnType instanceof \PHPStan\Type\FloatType || $returnType instanceof \PHPStan\Type\StringType || $returnType instanceof \PHPStan\Type\IntegerType) {
            $phpDocInfo->removeByType(\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
            return;
        }
        $this->removeNonUniqueUselessDocNames($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeShortObjectType($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeNullableType($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeFullyQualifiedObjectType($returnType, $returnTagValueNode, $phpDocInfo);
    }
    private function removeNonUniqueUselessDocNames(\PHPStan\Type\Type $returnType, \PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        foreach (self::USELESS_DOC_NAMES_BY_TYPE_CLASS as $typeClass => $uselessDocNames) {
            if (!\is_a($returnType, $typeClass, \true)) {
                continue;
            }
            if (!$this->isIdentifierWithValues($returnTagValueNode->type, $uselessDocNames)) {
                continue;
            }
            $phpDocInfo->removeByType(\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
            return;
        }
    }
    private function removeShortObjectType(\PHPStan\Type\Type $returnType, \PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        if (!$returnType instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return;
        }
        if (!$this->isIdentifierWithValues($returnTagValueNode->type, [$returnType->getShortName()])) {
            return;
        }
        $phpDocInfo->removeByType(\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
    }
    private function removeNullableType(\PHPStan\Type\Type $returnType, \PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $nullabledReturnType = $this->matchNullabledType($returnType);
        if ($nullabledReturnType === null) {
            return;
        }
        $nullabledReturnTagValueNode = $this->matchNullabledReturnTagValueNode($returnTagValueNode);
        if ($nullabledReturnTagValueNode === null) {
            return;
        }
        if (!$nullabledReturnType instanceof \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType) {
            return;
        }
        if (!$nullabledReturnTagValueNode instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return;
        }
        if (!\_PhpScoper5edc98a7cce2\Nette\Utils\Strings::endsWith($nullabledReturnType->getClassName(), $nullabledReturnTagValueNode->name)) {
            return;
        }
        $phpDocInfo->removeByType(\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
    }
    private function removeFullyQualifiedObjectType(\PHPStan\Type\Type $returnType, \PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        if (!$returnType instanceof \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType) {
            return;
        }
        if (!$returnTagValueNode->type instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return;
        }
        $className = $returnType->getClassName();
        $returnTagValueNodeType = (string) $returnTagValueNode->type;
        if ($this->isClassNameAndPartMatch($className, $returnTagValueNodeType)) {
            $phpDocInfo->removeByType(\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
        }
    }
    /**
     * @param string[] $values
     */
    private function isIdentifierWithValues(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, array $values) : bool
    {
        if (!$typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return \false;
        }
        return \in_array($typeNode->name, $values, \true);
    }
    private function matchNullabledType(\PHPStan\Type\Type $returnType) : ?\PHPStan\Type\Type
    {
        if (!$returnType instanceof \PHPStan\Type\UnionType) {
            return null;
        }
        if (!$returnType->isSuperTypeOf(new \PHPStan\Type\NullType())->yes()) {
            return null;
        }
        if (\count($returnType->getTypes()) !== 2) {
            return null;
        }
        foreach ($returnType->getTypes() as $unionedReturnType) {
            if ($unionedReturnType instanceof \PHPStan\Type\NullType) {
                continue;
            }
            return $unionedReturnType;
        }
        return null;
    }
    private function matchNullabledReturnTagValueNode(\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode) : ?\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if (!$returnTagValueNode->type instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return null;
        }
        if (\count($returnTagValueNode->type->types) !== 2) {
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
        return \_PhpScoper5edc98a7cce2\Nette\Utils\Strings::endsWith($className, '\\' . $returnTagValueNodeType);
    }
}
