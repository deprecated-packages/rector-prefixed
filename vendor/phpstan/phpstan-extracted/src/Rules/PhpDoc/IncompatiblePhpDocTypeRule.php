<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\PhpDoc;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\FunctionLike>
 */
class IncompatiblePhpDocTypeRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var FileTypeMapper */
    private $fileTypeMapper;
    /** @var \PHPStan\Rules\Generics\GenericObjectTypeCheck */
    private $genericObjectTypeCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper $fileTypeMapper, \_PhpScopere8e811afab72\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->genericObjectTypeCheck = $genericObjectTypeCheck;
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
        $nativeParameterTypes = $this->getNativeParameterTypes($node, $scope);
        $nativeReturnType = $this->getNativeReturnType($node, $scope);
        $errors = [];
        foreach ($resolvedPhpDoc->getParamTags() as $parameterName => $phpDocParamTag) {
            $phpDocParamType = $phpDocParamTag->getType();
            if (!isset($nativeParameterTypes[$parameterName])) {
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param references unknown parameter: $%s', $parameterName))->identifier('phpDoc.unknownParameter')->metadata(['parameterName' => $parameterName])->build();
            } elseif ($phpDocParamType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType || $phpDocParamType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType && !$phpDocParamType->isExplicit()) {
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param for parameter $%s contains unresolvable type.', $parameterName))->build();
            } else {
                $nativeParamType = $nativeParameterTypes[$parameterName];
                if ($phpDocParamTag->isVariadic() && $phpDocParamType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType && !$nativeParamType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                    $phpDocParamType = $phpDocParamType->getItemType();
                }
                $isParamSuperType = $nativeParamType->isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($phpDocParamType));
                $errors = \array_merge($errors, $this->genericObjectTypeCheck->check($phpDocParamType, \sprintf('PHPDoc tag @param for parameter $%s contains generic type %%s but class %%s is not generic.', $parameterName), \sprintf('Generic type %%s in PHPDoc tag @param for parameter $%s does not specify all template types of class %%s: %%s', $parameterName), \sprintf('Generic type %%s in PHPDoc tag @param for parameter $%s specifies %%d template types, but class %%s supports only %%d: %%s', $parameterName), \sprintf('Type %%s in generic type %%s in PHPDoc tag @param for parameter $%s is not subtype of template type %%s of class %%s.', $parameterName)));
                if ($isParamSuperType->no()) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param for parameter $%s with type %s is incompatible with native type %s.', $parameterName, $phpDocParamType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeParamType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                } elseif ($isParamSuperType->maybe()) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param for parameter $%s with type %s is not subtype of native type %s.', $parameterName, $phpDocParamType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeParamType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                }
            }
        }
        if ($resolvedPhpDoc->getReturnTag() !== null) {
            $phpDocReturnType = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($resolvedPhpDoc->getReturnTag()->getType());
            if ($phpDocReturnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType || $phpDocReturnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType && !$phpDocReturnType->isExplicit()) {
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('PHPDoc tag @return contains unresolvable type.')->build();
            } else {
                $isReturnSuperType = $nativeReturnType->isSuperTypeOf($phpDocReturnType);
                $errors = \array_merge($errors, $this->genericObjectTypeCheck->check($phpDocReturnType, 'PHPDoc tag @return contains generic type %s but class %s is not generic.', 'Generic type %s in PHPDoc tag @return does not specify all template types of class %s: %s', 'Generic type %s in PHPDoc tag @return specifies %d template types, but class %s supports only %d: %s', 'Type %s in generic type %s in PHPDoc tag @return is not subtype of template type %s of class %s.'));
                if ($isReturnSuperType->no()) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @return with type %s is incompatible with native type %s.', $phpDocReturnType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeReturnType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                } elseif ($isReturnSuperType->maybe()) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @return with type %s is not subtype of native type %s.', $phpDocReturnType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeReturnType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                }
            }
        }
        return $errors;
    }
    /**
     * @param Node\FunctionLike $node
     * @param Scope $scope
     * @return Type[]
     */
    private function getNativeParameterTypes(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $nativeParameterTypes = [];
        foreach ($node->getParams() as $parameter) {
            $isNullable = $scope->isParameterValueNullable($parameter);
            if (!$parameter->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable || !\is_string($parameter->var->name)) {
                throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
            }
            $nativeParameterTypes[$parameter->var->name] = $scope->getFunctionType($parameter->type, $isNullable, \false);
        }
        return $nativeParameterTypes;
    }
    private function getNativeReturnType(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $scope->getFunctionType($node->getReturnType(), \false, \false);
    }
}
