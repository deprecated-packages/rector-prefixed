<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Rule;
use _PhpScoper0a2ac50786fa\PHPStan\Type\FileTypeMapper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeScope;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Interface_>
 */
class InterfaceTemplateTypeRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Type\FileTypeMapper */
    private $fileTypeMapper;
    /** @var \PHPStan\Rules\Generics\TemplateTypeCheck */
    private $templateTypeCheck;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Type\FileTypeMapper $fileTypeMapper, \_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\TemplateTypeCheck $templateTypeCheck)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->templateTypeCheck = $templateTypeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Interface_::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        if (!isset($node->namespacedName)) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        $interfaceName = (string) $node->namespacedName;
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $interfaceName, null, null, $docComment->getText());
        return $this->templateTypeCheck->check($node, \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeScope::createWithClass($interfaceName), $resolvedPhpDoc->getTemplateTags(), \sprintf('PHPDoc tag @template for interface %s cannot have existing class %%s as its name.', $interfaceName), \sprintf('PHPDoc tag @template for interface %s cannot have existing type alias %%s as its name.', $interfaceName), \sprintf('PHPDoc tag @template %%s for interface %s has invalid bound type %%s.', $interfaceName), \sprintf('PHPDoc tag @template %%s for interface %s with bound type %%s is not supported.', $interfaceName));
    }
}
