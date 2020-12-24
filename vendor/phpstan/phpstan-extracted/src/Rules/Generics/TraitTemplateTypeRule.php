<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Generics;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeScope;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Trait_>
 */
class TraitTemplateTypeRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
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
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        if (!isset($node->namespacedName)) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $traitName = (string) $node->namespacedName;
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $traitName, null, null, $docComment->getText());
        return $this->templateTypeCheck->check($node, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeScope::createWithClass($traitName), $resolvedPhpDoc->getTemplateTags(), \sprintf('PHPDoc tag @template for trait %s cannot have existing class %%s as its name.', $traitName), \sprintf('PHPDoc tag @template for trait %s cannot have existing type alias %%s as its name.', $traitName), \sprintf('PHPDoc tag @template %%s for trait %s has invalid bound type %%s.', $traitName), \sprintf('PHPDoc tag @template %%s for trait %s with bound type %%s is not supported.', $traitName));
    }
}
