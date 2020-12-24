<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Generics;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag\ExtendsTag;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag\ImplementsTag;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Interface_>
 */
class InterfaceAncestorsRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Type\FileTypeMapper */
    private $fileTypeMapper;
    /** @var \PHPStan\Rules\Generics\GenericAncestorsCheck */
    private $genericAncestorsCheck;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper $fileTypeMapper, \_PhpScoperb75b35f52b74\PHPStan\Rules\Generics\GenericAncestorsCheck $genericAncestorsCheck)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->genericAncestorsCheck = $genericAncestorsCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!isset($node->namespacedName)) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        $interfaceName = (string) $node->namespacedName;
        $extendsTags = [];
        $implementsTags = [];
        $docComment = $node->getDocComment();
        if ($docComment !== null) {
            $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $interfaceName, null, null, $docComment->getText());
            $extendsTags = $resolvedPhpDoc->getExtendsTags();
            $implementsTags = $resolvedPhpDoc->getImplementsTags();
        }
        $extendsErrors = $this->genericAncestorsCheck->check($node->extends, \array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag\ExtendsTag $tag) : Type {
            return $tag->getType();
        }, $extendsTags), \sprintf('Interface %s @extends tag contains incompatible type %%s.', $interfaceName), \sprintf('Interface %s has @extends tag, but does not extend any interface.', $interfaceName), \sprintf('The @extends tag of interface %s describes %%s but the interface extends: %%s', $interfaceName), 'PHPDoc tag @extends contains generic type %s but interface %s is not generic.', 'Generic type %s in PHPDoc tag @extends does not specify all template types of interface %s: %s', 'Generic type %s in PHPDoc tag @extends specifies %d template types, but interface %s supports only %d: %s', 'Type %s in generic type %s in PHPDoc tag @extends is not subtype of template type %s of interface %s.', 'PHPDoc tag @extends has invalid type %s.', \sprintf('Interface %s extends generic interface %%s but does not specify its types: %%s', $interfaceName), \sprintf('in extended type %%s of interface %s', $interfaceName));
        $implementsErrors = $this->genericAncestorsCheck->check([], \array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag\ImplementsTag $tag) : Type {
            return $tag->getType();
        }, $implementsTags), \sprintf('Interface %s @implements tag contains incompatible type %%s.', $interfaceName), \sprintf('Interface %s has @implements tag, but can not implement any interface, must extend from it.', $interfaceName), '', '', '', '', '', '', '', '');
        return \array_merge($extendsErrors, $implementsErrors);
    }
}
