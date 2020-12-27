<?php

declare (strict_types=1);
namespace PHPStan\Rules\PhpDoc;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\FileTypeMapper;
use PHPStan\Type\ObjectType;
use PHPStan\Type\VerbosityLevel;
use PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\FunctionLike>
 */
class InvalidThrowsPhpDocValueRule implements \PHPStan\Rules\Rule
{
    /** @var FileTypeMapper */
    private $fileTypeMapper;
    public function __construct(\PHPStan\Type\FileTypeMapper $fileTypeMapper)
    {
        $this->fileTypeMapper = $fileTypeMapper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\FunctionLike::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $functionName = null;
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            $functionName = $node->name->name;
        } elseif ($node instanceof \PhpParser\Node\Stmt\Function_) {
            $functionName = \trim($scope->getNamespace() . '\\' . $node->name->name, '\\');
        }
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $scope->isInClass() ? $scope->getClassReflection()->getName() : null, $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null, $functionName, $docComment->getText());
        if ($resolvedPhpDoc->getThrowsTag() === null) {
            return [];
        }
        $phpDocThrowsType = $resolvedPhpDoc->getThrowsTag()->getType();
        if ((new \PHPStan\Type\VoidType())->isSuperTypeOf($phpDocThrowsType)->yes()) {
            return [];
        }
        $isThrowsSuperType = (new \PHPStan\Type\ObjectType(\Throwable::class))->isSuperTypeOf($phpDocThrowsType);
        if ($isThrowsSuperType->yes()) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @throws with type %s is not subtype of Throwable', $phpDocThrowsType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
