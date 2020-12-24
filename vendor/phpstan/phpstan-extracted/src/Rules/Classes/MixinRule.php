<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Classes;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\ClassNameNodePair;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<Node\Stmt\Class_>
 */
class MixinRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
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
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper $fileTypeMapper, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \_PhpScopere8e811afab72\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck, \_PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck $missingTypehintCheck, bool $checkClassCaseSensitivity)
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
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
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
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @mixin contains non-object type %s.', $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
                continue;
            }
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType && !$type->isExplicit()) {
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('PHPDoc tag @mixin contains unresolvable type.')->build();
                continue;
            }
            $errors = \array_merge($errors, $this->genericObjectTypeCheck->check($type, 'PHPDoc tag @mixin contains generic type %s but class %s is not generic.', 'Generic type %s in PHPDoc tag @mixin does not specify all template types of class %s: %s', 'Generic type %s in PHPDoc tag @mixin specifies %d template types, but class %s supports only %d: %s', 'Type %s in generic type %s in PHPDoc tag @mixin is not subtype of template type %s of class %s.'));
            foreach ($this->missingTypehintCheck->getNonGenericObjectTypesWithGenericClass($type) as [$innerName, $genericTypeNames]) {
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @mixin contains generic %s but does not specify its types: %s', $innerName, \implode(', ', $genericTypeNames)))->tip(\_PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_NON_GENERIC_CHECK_TIP)->build();
            }
            foreach ($type->getReferencedClasses() as $class) {
                if (!$this->reflectionProvider->hasClass($class)) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @mixin contains unknown class %s.', $class))->discoveringSymbolsTip()->build();
                } elseif ($this->reflectionProvider->getClass($class)->isTrait()) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('PHPDoc tag @mixin contains invalid type %s.', $class))->build();
                } elseif ($this->checkClassCaseSensitivity) {
                    $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScopere8e811afab72\PHPStan\Rules\ClassNameNodePair($class, $node)]));
                }
            }
        }
        return $errors;
    }
}
