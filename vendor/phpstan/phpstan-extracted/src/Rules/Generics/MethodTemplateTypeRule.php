<?php

declare (strict_types=1);
namespace PHPStan\Rules\Generics;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\FileTypeMapper;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\ClassMethod>
 */
class MethodTemplateTypeRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Type\FileTypeMapper */
    private $fileTypeMapper;
    /** @var \PHPStan\Rules\Generics\TemplateTypeCheck */
    private $templateTypeCheck;
    public function __construct(\PHPStan\Type\FileTypeMapper $fileTypeMapper, \PHPStan\Rules\Generics\TemplateTypeCheck $templateTypeCheck)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->templateTypeCheck = $templateTypeCheck;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\ClassMethod::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        if (!$scope->isInClass()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        $className = $classReflection->getDisplayName();
        $methodName = $node->name->toString();
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $className, $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null, $methodName, $docComment->getText());
        $methodTemplateTags = $resolvedPhpDoc->getTemplateTags();
        $messages = $this->templateTypeCheck->check($node, \PHPStan\Type\Generic\TemplateTypeScope::createWithMethod($className, $methodName), $methodTemplateTags, \sprintf('PHPDoc tag @template for method %s::%s() cannot have existing class %%s as its name.', $className, $methodName), \sprintf('PHPDoc tag @template for method %s::%s() cannot have existing type alias %%s as its name.', $className, $methodName), \sprintf('PHPDoc tag @template %%s for method %s::%s() has invalid bound type %%s.', $className, $methodName), \sprintf('PHPDoc tag @template %%s for method %s::%s() with bound type %%s is not supported.', $className, $methodName));
        $classTemplateTypes = $classReflection->getTemplateTypeMap()->getTypes();
        foreach (\array_keys($methodTemplateTags) as $name) {
            if (!isset($classTemplateTypes[$name])) {
                continue;
            }
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @template %s for method %s::%s() shadows @template %s for class %s.', $name, $className, $methodName, $classTemplateTypes[$name]->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName(\false)))->build();
        }
        return $messages;
    }
}
