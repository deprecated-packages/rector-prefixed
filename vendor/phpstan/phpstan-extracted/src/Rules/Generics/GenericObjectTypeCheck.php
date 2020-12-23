<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics;

use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeTraverser;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
class GenericObjectTypeCheck
{
    /**
     * @param \PHPStan\Type\Type $phpDocType
     * @param string $classNotGenericMessage
     * @param string $notEnoughTypesMessage
     * @param string $extraTypesMessage
     * @param string $typeIsNotSubtypeMessage
     * @return \PHPStan\Rules\RuleError[]
     */
    public function check(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $phpDocType, string $classNotGenericMessage, string $notEnoughTypesMessage, string $extraTypesMessage, string $typeIsNotSubtypeMessage) : array
    {
        $genericTypes = $this->getGenericTypes($phpDocType);
        $messages = [];
        foreach ($genericTypes as $genericType) {
            $classReflection = $genericType->getClassReflection();
            if ($classReflection === null) {
                continue;
            }
            if (!$classReflection->isGeneric()) {
                $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($classNotGenericMessage, $genericType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName()))->build();
                continue;
            }
            $templateTypes = \array_values($classReflection->getTemplateTypeMap()->getTypes());
            $genericTypeTypes = $genericType->getTypes();
            $templateTypesCount = \count($templateTypes);
            $genericTypeTypesCount = \count($genericTypeTypes);
            if ($templateTypesCount > $genericTypeTypesCount) {
                $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($notEnoughTypesMessage, $genericType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName(\false), \implode(', ', \array_keys($classReflection->getTemplateTypeMap()->getTypes()))))->build();
            } elseif ($templateTypesCount < $genericTypeTypesCount) {
                $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($extraTypesMessage, $genericType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly()), $genericTypeTypesCount, $classReflection->getDisplayName(\false), $templateTypesCount, \implode(', ', \array_keys($classReflection->getTemplateTypeMap()->getTypes()))))->build();
            }
            foreach ($templateTypes as $i => $templateType) {
                if (!isset($genericTypeTypes[$i])) {
                    continue;
                }
                $boundType = $templateType;
                if ($templateType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType) {
                    $boundType = $templateType->getBound();
                }
                $genericTypeType = $genericTypeTypes[$i];
                if ($boundType->isSuperTypeOf($genericTypeType)->yes()) {
                    continue;
                }
                $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($typeIsNotSubtypeMessage, $genericTypeType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly()), $genericType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly()), $templateType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName(\false)))->build();
            }
        }
        return $messages;
    }
    /**
     * @param \PHPStan\Type\Type $phpDocType
     * @return \PHPStan\Type\Generic\GenericObjectType[]
     */
    private function getGenericTypes(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $phpDocType) : array
    {
        $genericObjectTypes = [];
        \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeTraverser::map($phpDocType, static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, callable $traverse) use(&$genericObjectTypes) : Type {
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType) {
                $resolvedType = \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($type);
                if (!$resolvedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType) {
                    throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
                }
                $genericObjectTypes[] = $resolvedType;
                $traverse($type);
                return $type;
            }
            $traverse($type);
            return $type;
        });
        return $genericObjectTypes;
    }
}
