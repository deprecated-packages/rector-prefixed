<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\PhpDocParser;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\CallableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ParentStaticType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\SelfObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType;
final class NonInformativeReturnTagRemover
{
    /**
     * @var string[][]
     */
    private const USELESS_DOC_NAMES_BY_TYPE_CLASS = [\_PhpScoperb75b35f52b74\PHPStan\Type\IterableType::class => ['iterable'], \_PhpScoperb75b35f52b74\PHPStan\Type\CallableType::class => ['callable'], \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType::class => ['void'], \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType::class => ['array'], \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\SelfObjectType::class => ['self'], \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ParentStaticType::class => ['parent'], \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType::class => ['bool', 'boolean'], \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType::class => ['object']];
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    public function removeReturnTagIfNotUseful(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : void
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $returnTagValueNode = $phpDocInfo->getByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
        if ($returnTagValueNode === null) {
            return;
        }
        // useful
        if ($returnTagValueNode->description !== '') {
            return;
        }
        $returnType = $phpDocInfo->getReturnType();
        // is bare type
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType || $returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StringType || $returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType) {
            $phpDocInfo->removeByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
            return;
        }
        $this->removeNonUniqueUselessDocNames($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeShortObjectType($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeNullableType($returnType, $returnTagValueNode, $phpDocInfo);
        $this->removeFullyQualifiedObjectType($returnType, $returnTagValueNode, $phpDocInfo);
    }
    private function removeNonUniqueUselessDocNames(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        foreach (self::USELESS_DOC_NAMES_BY_TYPE_CLASS as $typeClass => $uselessDocNames) {
            if (!\is_a($returnType, $typeClass, \true)) {
                continue;
            }
            if (!$this->isIdentifierWithValues($returnTagValueNode->type, $uselessDocNames)) {
                continue;
            }
            $phpDocInfo->removeByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
            return;
        }
    }
    private function removeShortObjectType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        if (!$returnType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
            return;
        }
        if (!$this->isIdentifierWithValues($returnTagValueNode->type, [$returnType->getShortName()])) {
            return;
        }
        $phpDocInfo->removeByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
    }
    private function removeNullableType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $nullabledReturnType = $this->matchNullabledType($returnType);
        if ($nullabledReturnType === null) {
            return;
        }
        $nullabledReturnTagValueNode = $this->matchNullabledReturnTagValueNode($returnTagValueNode);
        if ($nullabledReturnTagValueNode === null) {
            return;
        }
        if (!$nullabledReturnType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return;
        }
        if (!$nullabledReturnTagValueNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return;
        }
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($nullabledReturnType->getClassName(), $nullabledReturnTagValueNode->name)) {
            return;
        }
        $phpDocInfo->removeByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
    }
    private function removeFullyQualifiedObjectType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType, \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        if (!$returnType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return;
        }
        if (!$returnTagValueNode->type instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return;
        }
        $className = $returnType->getClassName();
        $returnTagValueNodeType = (string) $returnTagValueNode->type;
        if ($this->isClassNameAndPartMatch($className, $returnTagValueNodeType)) {
            $phpDocInfo->removeByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode::class);
        }
    }
    /**
     * @param string[] $values
     */
    private function isIdentifierWithValues(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, array $values) : bool
    {
        if (!$typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return \false;
        }
        return \in_array($typeNode->name, $values, \true);
    }
    private function matchNullabledType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (!$returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return null;
        }
        if (!$returnType->isSuperTypeOf(new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType())->yes()) {
            return null;
        }
        if (\count($returnType->getTypes()) !== 2) {
            return null;
        }
        foreach ($returnType->getTypes() as $unionedReturnType) {
            if ($unionedReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
                continue;
            }
            return $unionedReturnType;
        }
        return null;
    }
    private function matchNullabledReturnTagValueNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode) : ?\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if (!$returnTagValueNode->type instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
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
        return \_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($className, '\\' . $returnTagValueNodeType);
    }
}
