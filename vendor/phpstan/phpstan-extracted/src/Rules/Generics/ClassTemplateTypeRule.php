<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Generics;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\InClassNode;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeScope;
/**
 * @implements \PHPStan\Rules\Rule<InClassNode>
 */
class ClassTemplateTypeRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Generics\TemplateTypeCheck */
    private $templateTypeCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\Generics\TemplateTypeCheck $templateTypeCheck)
    {
        $this->templateTypeCheck = $templateTypeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\InClassNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            return [];
        }
        $classReflection = $scope->getClassReflection();
        $className = $classReflection->getName();
        if ($classReflection->isAnonymous()) {
            $displayName = 'anonymous class';
        } else {
            $displayName = 'class ' . $classReflection->getDisplayName();
        }
        return $this->templateTypeCheck->check($node, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeScope::createWithClass($className), $classReflection->getTemplateTags(), \sprintf('PHPDoc tag @template for %s cannot have existing class %%s as its name.', $displayName), \sprintf('PHPDoc tag @template for %s cannot have existing type alias %%s as its name.', $displayName), \sprintf('PHPDoc tag @template %%s for %s has invalid bound type %%s.', $displayName), \sprintf('PHPDoc tag @template %%s for %s with bound type %%s is not supported.', $displayName));
    }
}
