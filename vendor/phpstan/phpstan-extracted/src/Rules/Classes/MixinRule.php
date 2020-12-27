<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Classes;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck;
use RectorPrefix20201227\PHPStan\Rules\ClassNameNodePair;
use RectorPrefix20201227\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ErrorType;
use PHPStan\Type\FileTypeMapper;
use PHPStan\Type\NeverType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<Node\Stmt\Class_>
 */
class MixinRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var FileTypeMapper */
    private $fileTypeMapper;
    /** @var ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var \PHPStan\Rules\Generics\GenericObjectTypeCheck */
    private $genericObjectTypeCheck;
    /** @var MissingTypehintCheck */
    private $missingTypehintCheck;
    /** @var bool */
    private $checkClassCaseSensitivity;
    public function __construct(\PHPStan\Type\FileTypeMapper $fileTypeMapper, \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \RectorPrefix20201227\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck, \RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck, bool $checkClassCaseSensitivity)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->genericObjectTypeCheck = $genericObjectTypeCheck;
        $this->missingTypehintCheck = $missingTypehintCheck;
        $this->checkClassCaseSensitivity = $checkClassCaseSensitivity;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Class_::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!isset($node->namespacedName)) {
            // anonymous class
            return [];
        }
        $className = (string) $node->namespacedName;
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $className, null, null, $docComment->getText());
        $mixinTags = $resolvedPhpDoc->getMixinTags();
        $errors = [];
        foreach ($mixinTags as $mixinTag) {
            $type = $mixinTag->getType();
            if (!$type->canCallMethods()->yes() || !$type->canAccessProperties()->yes()) {
                $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @mixin contains non-object type %s.', $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                continue;
            }
            if ($type instanceof \PHPStan\Type\ErrorType || $type instanceof \PHPStan\Type\NeverType && !$type->isExplicit()) {
                $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message('PHPDoc tag @mixin contains unresolvable type.')->build();
                continue;
            }
            $errors = \array_merge($errors, $this->genericObjectTypeCheck->check($type, 'PHPDoc tag @mixin contains generic type %s but class %s is not generic.', 'Generic type %s in PHPDoc tag @mixin does not specify all template types of class %s: %s', 'Generic type %s in PHPDoc tag @mixin specifies %d template types, but class %s supports only %d: %s', 'Type %s in generic type %s in PHPDoc tag @mixin is not subtype of template type %s of class %s.'));
            foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($type) as [$innerName, $genericTypeNames]) {
                $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @mixin contains generic %s but does not specify its types: %s', $innerName, \implode(', ', $genericTypeNames)))->tip(\RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
            }
            foreach ($type->getReferencedClasses() as $class) {
                if (!$this->reflectionProvider->hasClass($class)) {
                    $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @mixin contains unknown class %s.', $class))->discoveringSymbolsTip()->build();
                } elseif ($this->reflectionProvider->getClass($class)->isTrait()) {
                    $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @mixin contains invalid type %s.', $class))->build();
                } elseif ($this->checkClassCaseSensitivity) {
                    $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames([new \RectorPrefix20201227\PHPStan\Rules\ClassNameNodePair($class, $node)]));
                }
            }
        }
        return $errors;
    }
}
