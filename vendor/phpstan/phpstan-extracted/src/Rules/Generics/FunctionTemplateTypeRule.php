<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Generics;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeScope;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Function_>
 */
class FunctionTemplateTypeRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Type\FileTypeMapper */
    private $fileTypeMapper;
    /** @var \PHPStan\Rules\Generics\TemplateTypeCheck */
    private $templateTypeCheck;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper $fileTypeMapper, \_PhpScoperb75b35f52b74\PHPStan\Rules\Generics\TemplateTypeCheck $templateTypeCheck)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->templateTypeCheck = $templateTypeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        if (!isset($node->namespacedName)) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        $functionName = (string) $node->namespacedName;
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), null, null, $functionName, $docComment->getText());
        return $this->templateTypeCheck->check($node, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction($functionName), $resolvedPhpDoc->getTemplateTags(), \sprintf('PHPDoc tag @template for function %s() cannot have existing class %%s as its name.', $functionName), \sprintf('PHPDoc tag @template for function %s() cannot have existing type alias %%s as its name.', $functionName), \sprintf('PHPDoc tag @template %%s for function %s() has invalid bound type %%s.', $functionName), \sprintf('PHPDoc tag @template %%s for function %s() with bound type %%s is not supported.', $functionName));
    }
}
