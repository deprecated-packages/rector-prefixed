<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\PhpDoc;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\FileTypeMapper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NeverType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\FunctionLike>
 */
class IncompatiblePhpDocTypeRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var FileTypeMapper */
    private $fileTypeMapper;
    /** @var \PHPStan\Rules\Generics\GenericObjectTypeCheck */
    private $genericObjectTypeCheck;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Type\FileTypeMapper $fileTypeMapper, \_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->genericObjectTypeCheck = $genericObjectTypeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $functionName = null;
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod) {
            $functionName = $node->name->name;
        } elseif ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_) {
            $functionName = \trim($scope->getNamespace() . '\\' . $node->name->name, '\\');
        }
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $scope->isInClass() ? $scope->getClassReflection()->getName() : null, $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null, $functionName, $docComment->getText());
        $nativeParameterTypes = $this->getNativeParameterTypes($node, $scope);
        $nativeReturnType = $this->getNativeReturnType($node, $scope);
        $errors = [];
        foreach ($resolvedPhpDoc->getParamTags() as $parameterName => $phpDocParamTag) {
            $phpDocParamType = $phpDocParamTag->getType();
            if (!isset($nativeParameterTypes[$parameterName])) {
                $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param references unknown parameter: $%s', $parameterName))->identifier('phpDoc.unknownParameter')->metadata(['parameterName' => $parameterName])->build();
            } elseif ($phpDocParamType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType || $phpDocParamType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType && !$phpDocParamType->isExplicit()) {
                $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param for parameter $%s contains unresolvable type.', $parameterName))->build();
            } else {
                $nativeParamType = $nativeParameterTypes[$parameterName];
                if ($phpDocParamTag->isVariadic() && $phpDocParamType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType && !$nativeParamType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                    $phpDocParamType = $phpDocParamType->getItemType();
                }
                $isParamSuperType = $nativeParamType->isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($phpDocParamType));
                $errors = \array_merge($errors, $this->genericObjectTypeCheck->check($phpDocParamType, \sprintf('PHPDoc tag @param for parameter $%s contains generic type %%s but class %%s is not generic.', $parameterName), \sprintf('Generic type %%s in PHPDoc tag @param for parameter $%s does not specify all template types of class %%s: %%s', $parameterName), \sprintf('Generic type %%s in PHPDoc tag @param for parameter $%s specifies %%d template types, but class %%s supports only %%d: %%s', $parameterName), \sprintf('Type %%s in generic type %%s in PHPDoc tag @param for parameter $%s is not subtype of template type %%s of class %%s.', $parameterName)));
                if ($isParamSuperType->no()) {
                    $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param for parameter $%s with type %s is incompatible with native type %s.', $parameterName, $phpDocParamType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeParamType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                } elseif ($isParamSuperType->maybe()) {
                    $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @param for parameter $%s with type %s is not subtype of native type %s.', $parameterName, $phpDocParamType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeParamType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                }
            }
        }
        if ($resolvedPhpDoc->getReturnTag() !== null) {
            $phpDocReturnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($resolvedPhpDoc->getReturnTag()->getType());
            if ($phpDocReturnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType || $phpDocReturnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType && !$phpDocReturnType->isExplicit()) {
                $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message('PHPDoc tag @return contains unresolvable type.')->build();
            } else {
                $isReturnSuperType = $nativeReturnType->isSuperTypeOf($phpDocReturnType);
                $errors = \array_merge($errors, $this->genericObjectTypeCheck->check($phpDocReturnType, 'PHPDoc tag @return contains generic type %s but class %s is not generic.', 'Generic type %s in PHPDoc tag @return does not specify all template types of class %s: %s', 'Generic type %s in PHPDoc tag @return specifies %d template types, but class %s supports only %d: %s', 'Type %s in generic type %s in PHPDoc tag @return is not subtype of template type %s of class %s.'));
                if ($isReturnSuperType->no()) {
                    $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @return with type %s is incompatible with native type %s.', $phpDocReturnType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeReturnType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                } elseif ($isReturnSuperType->maybe()) {
                    $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @return with type %s is not subtype of native type %s.', $phpDocReturnType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeReturnType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
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
    private function getNativeParameterTypes(\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $nativeParameterTypes = [];
        foreach ($node->getParams() as $parameter) {
            $isNullable = $scope->isParameterValueNullable($parameter);
            if (!$parameter->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable || !\is_string($parameter->var->name)) {
                throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
            }
            $nativeParameterTypes[$parameter->var->name] = $scope->getFunctionType($parameter->type, $isNullable, \false);
        }
        return $nativeParameterTypes;
    }
    private function getNativeReturnType(\_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $scope->getFunctionType($node->getReturnType(), \false, \false);
    }
}
