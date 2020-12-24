<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\PhpDoc;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\FileTypeMapper;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
use _PhpScoper0a6b37af0871\PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\FunctionLike>
 */
class InvalidThrowsPhpDocValueRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var FileTypeMapper */
    private $fileTypeMapper;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Type\FileTypeMapper $fileTypeMapper)
    {
        $this->fileTypeMapper = $fileTypeMapper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $functionName = null;
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
            $functionName = $node->name->name;
        } elseif ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_) {
            $functionName = \trim($scope->getNamespace() . '\\' . $node->name->name, '\\');
        }
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $scope->isInClass() ? $scope->getClassReflection()->getName() : null, $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null, $functionName, $docComment->getText());
        if ($resolvedPhpDoc->getThrowsTag() === null) {
            return [];
        }
        $phpDocThrowsType = $resolvedPhpDoc->getThrowsTag()->getType();
        if ((new \_PhpScoper0a6b37af0871\PHPStan\Type\VoidType())->isSuperTypeOf($phpDocThrowsType)->yes()) {
            return [];
        }
        $isThrowsSuperType = (new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\Throwable::class))->isSuperTypeOf($phpDocThrowsType);
        if ($isThrowsSuperType->yes()) {
            return [];
        }
        return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @throws with type %s is not subtype of Throwable', $phpDocThrowsType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
