<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Generics;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeScope;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\ClassMethod>
 */
class MethodTemplateTypeRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Type\FileTypeMapper */
    private $fileTypeMapper;
    /** @var \PHPStan\Rules\Generics\TemplateTypeCheck */
    private $templateTypeCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper $fileTypeMapper, \_PhpScopere8e811afab72\PHPStan\Rules\Generics\TemplateTypeCheck $templateTypeCheck)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->templateTypeCheck = $templateTypeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        if (!$scope->isInClass()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        $className = $classReflection->getDisplayName();
        $methodName = $node->name->toString();
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $className, $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null, $methodName, $docComment->getText());
        $methodTemplateTags = $resolvedPhpDoc->getTemplateTags();
        $messages = $this->templateTypeCheck->check($node, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeScope::createWithMethod($className, $methodName), $methodTemplateTags, \sprintf('PHPDoc tag @template for method %s::%s() cannot have existing class %%s as its name.', $className, $methodName), \sprintf('PHPDoc tag @template for method %s::%s() cannot have existing type alias %%s as its name.', $className, $methodName), \sprintf('PHPDoc tag @template %%s for method %s::%s() has invalid bound type %%s.', $className, $methodName), \sprintf('PHPDoc tag @template %%s for method %s::%s() with bound type %%s is not supported.', $className, $methodName));
        $classTemplateTypes = $classReflection->getTemplateTypeMap()->getTypes();
        foreach (\array_keys($methodTemplateTags) as $name) {
            if (!isset($classTemplateTypes[$name])) {
                continue;
            }
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @template %s for method %s::%s() shadows @template %s for class %s.', $name, $className, $methodName, $classTemplateTypes[$name]->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName(\false)))->build();
        }
        return $messages;
    }
}
