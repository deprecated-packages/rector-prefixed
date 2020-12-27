<?php

declare (strict_types=1);
namespace PHPStan\Rules\Generics;

use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Generic\TemplateType;
use PHPStan\Type\Generic\TemplateTypeHelper;
use PHPStan\Type\Type;
use PHPStan\Type\TypeTraverser;
use PHPStan\Type\VerbosityLevel;
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
    public function check(\PHPStan\Type\Type $phpDocType, string $classNotGenericMessage, string $notEnoughTypesMessage, string $extraTypesMessage, string $typeIsNotSubtypeMessage) : array
    {
        $genericTypes = $this->getGenericTypes($phpDocType);
        $messages = [];
        foreach ($genericTypes as $genericType) {
            $classReflection = $genericType->getClassReflection();
            if ($classReflection === null) {
                continue;
            }
            if (!$classReflection->isGeneric()) {
                $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf($classNotGenericMessage, $genericType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName()))->build();
                continue;
            }
            $templateTypes = \array_values($classReflection->getTemplateTypeMap()->getTypes());
            $genericTypeTypes = $genericType->getTypes();
            $templateTypesCount = \count($templateTypes);
            $genericTypeTypesCount = \count($genericTypeTypes);
            if ($templateTypesCount > $genericTypeTypesCount) {
                $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf($notEnoughTypesMessage, $genericType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName(\false), \implode(', ', \array_keys($classReflection->getTemplateTypeMap()->getTypes()))))->build();
            } elseif ($templateTypesCount < $genericTypeTypesCount) {
                $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf($extraTypesMessage, $genericType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $genericTypeTypesCount, $classReflection->getDisplayName(\false), $templateTypesCount, \implode(', ', \array_keys($classReflection->getTemplateTypeMap()->getTypes()))))->build();
            }
            foreach ($templateTypes as $i => $templateType) {
                if (!isset($genericTypeTypes[$i])) {
                    continue;
                }
                $boundType = $templateType;
                if ($templateType instanceof \PHPStan\Type\Generic\TemplateType) {
                    $boundType = $templateType->getBound();
                }
                $genericTypeType = $genericTypeTypes[$i];
                if ($boundType->isSuperTypeOf($genericTypeType)->yes()) {
                    continue;
                }
                $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf($typeIsNotSubtypeMessage, $genericTypeType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $genericType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $templateType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName(\false)))->build();
            }
        }
        return $messages;
    }
    /**
     * @param \PHPStan\Type\Type $phpDocType
     * @return \PHPStan\Type\Generic\GenericObjectType[]
     */
    private function getGenericTypes(\PHPStan\Type\Type $phpDocType) : array
    {
        $genericObjectTypes = [];
        \PHPStan\Type\TypeTraverser::map($phpDocType, static function (\PHPStan\Type\Type $type, callable $traverse) use(&$genericObjectTypes) : Type {
            if ($type instanceof \PHPStan\Type\Generic\GenericObjectType) {
                $resolvedType = \PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($type);
                if (!$resolvedType instanceof \PHPStan\Type\Generic\GenericObjectType) {
                    throw new \PHPStan\ShouldNotHappenException();
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
