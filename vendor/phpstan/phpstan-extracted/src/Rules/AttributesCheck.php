<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules;

use _PhpScopere8e811afab72\PhpParser\Node\AttributeGroup;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
class AttributesCheck
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    /** @var FunctionCallParametersCheck */
    private $functionCallParametersCheck;
    /** @var ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\PHPStan\Rules\FunctionCallParametersCheck $functionCallParametersCheck, \_PhpScopere8e811afab72\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->functionCallParametersCheck = $functionCallParametersCheck;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
    }
    /**
     * @param AttributeGroup[] $attrGroups
     * @param \Attribute::TARGET_* $requiredTarget
     * @return RuleError[]
     */
    public function check(\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, array $attrGroups, int $requiredTarget, string $targetName) : array
    {
        $errors = [];
        $alreadyPresent = [];
        foreach ($attrGroups as $attrGroup) {
            foreach ($attrGroup->attrs as $attribute) {
                $name = $attribute->name->toString();
                if (!$this->reflectionProvider->hasClass($name)) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Attribute class %s does not exist.', $name))->line($attribute->getLine())->build();
                    continue;
                }
                $attributeClass = $this->reflectionProvider->getClass($name);
                if (!$attributeClass->isAttributeClass()) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Class %s is not an Attribute class.', $attributeClass->getDisplayName()))->line($attribute->getLine())->build();
                    continue;
                }
                if ($attributeClass->isAbstract()) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Attribute class %s is abstract.', $name))->line($attribute->getLine())->build();
                }
                foreach ($this->classCaseSensitivityCheck->checkClassNames([new \_PhpScopere8e811afab72\PHPStan\Rules\ClassNameNodePair($name, $attribute)]) as $caseSensitivityError) {
                    $errors[] = $caseSensitivityError;
                }
                $flags = $attributeClass->getAttributeClassFlags();
                if (($flags & $requiredTarget) === 0) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Attribute class %s does not have the %s target.', $name, $targetName))->line($attribute->getLine())->build();
                }
                if (($flags & \Attribute::IS_REPEATABLE) === 0) {
                    $loweredName = \strtolower($name);
                    if (\array_key_exists($loweredName, $alreadyPresent)) {
                        $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Attribute class %s is not repeatable but is already present above the %s.', $name, $targetName))->line($attribute->getLine())->build();
                    }
                    $alreadyPresent[$loweredName] = \true;
                }
                if (!$attributeClass->hasConstructor()) {
                    if (\count($attribute->args) > 0) {
                        $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Attribute class %s does not have a constructor and must be instantiated without any parameters.', $name))->line($attribute->getLine())->build();
                    }
                    continue;
                }
                $attributeConstructor = $attributeClass->getConstructor();
                if (!$attributeConstructor->isPublic()) {
                    $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Constructor of attribute class %s is not public.', $name))->line($attribute->getLine())->build();
                }
                $parameterErrors = $this->functionCallParametersCheck->check(\_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($attributeConstructor->getVariants()), $scope, $attributeConstructor->getDeclaringClass()->isBuiltin(), new \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_($attribute->name, $attribute->args, $attribute->getAttributes()), [
                    'Attribute class ' . $attributeClass->getDisplayName() . ' constructor invoked with %d parameter, %d required.',
                    'Attribute class ' . $attributeClass->getDisplayName() . ' constructor invoked with %d parameters, %d required.',
                    'Attribute class ' . $attributeClass->getDisplayName() . ' constructor invoked with %d parameter, at least %d required.',
                    'Attribute class ' . $attributeClass->getDisplayName() . ' constructor invoked with %d parameters, at least %d required.',
                    'Attribute class ' . $attributeClass->getDisplayName() . ' constructor invoked with %d parameter, %d-%d required.',
                    'Attribute class ' . $attributeClass->getDisplayName() . ' constructor invoked with %d parameters, %d-%d required.',
                    'Parameter %s of attribute class ' . $attributeClass->getDisplayName() . ' constructor expects %s, %s given.',
                    '',
                    // constructor does not have a return type
                    'Parameter %s of attribute class ' . $attributeClass->getDisplayName() . ' constructor is passed by reference, so it expects variables only',
                    'Unable to resolve the template type %s in instantiation of attribute class ' . $attributeClass->getDisplayName(),
                    'Missing parameter $%s in call to ' . $attributeClass->getDisplayName() . ' constructor.',
                    'Unknown parameter $%s in call to ' . $attributeClass->getDisplayName() . ' constructor.',
                ]);
                foreach ($parameterErrors as $error) {
                    $errors[] = $error;
                }
            }
        }
        return $errors;
    }
}
