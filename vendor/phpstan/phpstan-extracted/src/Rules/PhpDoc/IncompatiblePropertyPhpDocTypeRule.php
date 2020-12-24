<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\PhpDoc;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\ClassPropertyNode;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClassPropertyNode>
 */
class IncompatiblePropertyPhpDocTypeRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Generics\GenericObjectTypeCheck */
    private $genericObjectTypeCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck)
    {
        $this->genericObjectTypeCheck = $genericObjectTypeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\ClassPropertyNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $propertyName = $node->getName();
        $propertyReflection = $scope->getClassReflection()->getNativeProperty($propertyName);
        if (!$propertyReflection->hasPhpDoc()) {
            return [];
        }
        $phpDocType = $propertyReflection->getPhpDocType();
        $description = 'PHPDoc tag @var';
        if ($propertyReflection->isPromoted()) {
            $description = 'PHPDoc type';
        }
        $messages = [];
        if ($phpDocType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType || $phpDocType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType && !$phpDocType->isExplicit()) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s for property %s::$%s contains unresolvable type.', $description, $propertyReflection->getDeclaringClass()->getName(), $propertyName))->build();
        }
        $nativeType = $propertyReflection->getNativeType();
        $isSuperType = $nativeType->isSuperTypeOf($phpDocType);
        if ($isSuperType->no()) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s for property %s::$%s with type %s is incompatible with native type %s.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName, $phpDocType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        } elseif ($isSuperType->maybe()) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s for property %s::$%s with type %s is not subtype of native type %s.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName, $phpDocType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        $messages = \array_merge($messages, $this->genericObjectTypeCheck->check($phpDocType, \sprintf('%s for property %s::$%s contains generic type %%s but class %%s is not generic.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName), \sprintf('Generic type %%s in %s for property %s::$%s does not specify all template types of class %%s: %%s', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName), \sprintf('Generic type %%s in %s for property %s::$%s specifies %%d template types, but class %%s supports only %%d: %%s', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName), \sprintf('Type %%s in generic type %%s in %s for property %s::$%s is not subtype of template type %%s of class %%s.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName)));
        return $messages;
    }
}
