<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Generics;

use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
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
    public function check(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocType, string $classNotGenericMessage, string $notEnoughTypesMessage, string $extraTypesMessage, string $typeIsNotSubtypeMessage) : array
    {
        $genericTypes = $this->getGenericTypes($phpDocType);
        $messages = [];
        foreach ($genericTypes as $genericType) {
            $classReflection = $genericType->getClassReflection();
            if ($classReflection === null) {
                continue;
            }
            if (!$classReflection->isGeneric()) {
                $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($classNotGenericMessage, $genericType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName()))->build();
                continue;
            }
            $templateTypes = \array_values($classReflection->getTemplateTypeMap()->getTypes());
            $genericTypeTypes = $genericType->getTypes();
            $templateTypesCount = \count($templateTypes);
            $genericTypeTypesCount = \count($genericTypeTypes);
            if ($templateTypesCount > $genericTypeTypesCount) {
                $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($notEnoughTypesMessage, $genericType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName(\false), \implode(', ', \array_keys($classReflection->getTemplateTypeMap()->getTypes()))))->build();
            } elseif ($templateTypesCount < $genericTypeTypesCount) {
                $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($extraTypesMessage, $genericType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $genericTypeTypesCount, $classReflection->getDisplayName(\false), $templateTypesCount, \implode(', ', \array_keys($classReflection->getTemplateTypeMap()->getTypes()))))->build();
            }
            foreach ($templateTypes as $i => $templateType) {
                if (!isset($genericTypeTypes[$i])) {
                    continue;
                }
                $boundType = $templateType;
                if ($templateType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
                    $boundType = $templateType->getBound();
                }
                $genericTypeType = $genericTypeTypes[$i];
                if ($boundType->isSuperTypeOf($genericTypeType)->yes()) {
                    continue;
                }
                $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($typeIsNotSubtypeMessage, $genericTypeType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $genericType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $templateType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $classReflection->getDisplayName(\false)))->build();
            }
        }
        return $messages;
    }
    /**
     * @param \PHPStan\Type\Type $phpDocType
     * @return \PHPStan\Type\Generic\GenericObjectType[]
     */
    private function getGenericTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocType) : array
    {
        $genericObjectTypes = [];
        \_PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser::map($phpDocType, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, callable $traverse) use(&$genericObjectTypes) : Type {
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType) {
                $resolvedType = \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($type);
                if (!$resolvedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType) {
                    throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
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
