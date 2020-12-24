<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\PhpDoc;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\FunctionLike>
 */
class InvalidThrowsPhpDocValueRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var FileTypeMapper */
    private $fileTypeMapper;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper $fileTypeMapper)
    {
        $this->fileTypeMapper = $fileTypeMapper;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $functionName = null;
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            $functionName = $node->name->name;
        } elseif ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_) {
            $functionName = \trim($scope->getNamespace() . '\\' . $node->name->name, '\\');
        }
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $scope->isInClass() ? $scope->getClassReflection()->getName() : null, $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null, $functionName, $docComment->getText());
        if ($resolvedPhpDoc->getThrowsTag() === null) {
            return [];
        }
        $phpDocThrowsType = $resolvedPhpDoc->getThrowsTag()->getType();
        if ((new \_PhpScopere8e811afab72\PHPStan\Type\VoidType())->isSuperTypeOf($phpDocThrowsType)->yes()) {
            return [];
        }
        $isThrowsSuperType = (new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\Throwable::class))->isSuperTypeOf($phpDocThrowsType);
        if ($isThrowsSuperType->yes()) {
            return [];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @throws with type %s is not subtype of Throwable', $phpDocThrowsType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
