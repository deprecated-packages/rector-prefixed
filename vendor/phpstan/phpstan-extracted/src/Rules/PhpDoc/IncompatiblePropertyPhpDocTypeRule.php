<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\PhpDoc;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Node\ClassPropertyNode;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NeverType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClassPropertyNode>
 */
class IncompatiblePropertyPhpDocTypeRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Generics\GenericObjectTypeCheck */
    private $genericObjectTypeCheck;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\Generics\GenericObjectTypeCheck $genericObjectTypeCheck)
    {
        $this->genericObjectTypeCheck = $genericObjectTypeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Node\ClassPropertyNode::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
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
        if ($phpDocType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType || $phpDocType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType && !$phpDocType->isExplicit()) {
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s for property %s::$%s contains unresolvable type.', $description, $propertyReflection->getDeclaringClass()->getName(), $propertyName))->build();
        }
        $nativeType = $propertyReflection->getNativeType();
        $isSuperType = $nativeType->isSuperTypeOf($phpDocType);
        if ($isSuperType->no()) {
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s for property %s::$%s with type %s is incompatible with native type %s.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName, $phpDocType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        } elseif ($isSuperType->maybe()) {
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s for property %s::$%s with type %s is not subtype of native type %s.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName, $phpDocType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly()), $nativeType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        $messages = \array_merge($messages, $this->genericObjectTypeCheck->check($phpDocType, \sprintf('%s for property %s::$%s contains generic type %%s but class %%s is not generic.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName), \sprintf('Generic type %%s in %s for property %s::$%s does not specify all template types of class %%s: %%s', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName), \sprintf('Generic type %%s in %s for property %s::$%s specifies %%d template types, but class %%s supports only %%d: %%s', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName), \sprintf('Type %%s in generic type %%s in %s for property %s::$%s is not subtype of template type %%s of class %%s.', $description, $propertyReflection->getDeclaringClass()->getDisplayName(), $propertyName)));
        return $messages;
    }
}
