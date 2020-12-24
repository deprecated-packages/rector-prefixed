<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class VarianceCheck
{
    /** @return RuleError[] */
    public function checkParametersAcceptor(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor, string $parameterTypeMessage, string $returnTypeMessage, string $generalMessage, bool $isStatic) : array
    {
        $errors = [];
        foreach ($parametersAcceptor->getParameters() as $parameterReflection) {
            $variance = $isStatic ? \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance::createStatic() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance::createContravariant();
            $type = $parameterReflection->getType();
            $message = \sprintf($parameterTypeMessage, $parameterReflection->getName());
            foreach ($this->check($variance, $type, $message) as $error) {
                $errors[] = $error;
            }
        }
        foreach ($parametersAcceptor->getTemplateTypeMap()->getTypes() as $templateType) {
            if (!$templateType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType || $templateType->getScope()->getFunctionName() === null || $templateType->getVariance()->invariant()) {
                continue;
            }
            $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variance annotation is only allowed for type parameters of classes and interfaces, but occurs in template type %s in %s.', $templateType->getName(), $generalMessage))->build();
        }
        $variance = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant();
        $type = $parametersAcceptor->getReturnType();
        foreach ($this->check($variance, $type, $returnTypeMessage) as $error) {
            $errors[] = $error;
        }
        return $errors;
    }
    /** @return RuleError[] */
    public function check(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, string $messageContext) : array
    {
        $errors = [];
        foreach ($type->getReferencedTemplateTypes($positionVariance) as $reference) {
            $referredType = $reference->getType();
            if ($referredType->getScope()->getFunctionName() !== null && !$referredType->getVariance()->invariant() || $this->isTemplateTypeVarianceValid($reference->getPositionVariance(), $referredType)) {
                continue;
            }
            $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Template type %s is declared as %s, but occurs in %s position %s.', $referredType->getName(), $referredType->getVariance()->describe(), $reference->getPositionVariance()->describe(), $messageContext))->build();
        }
        return $errors;
    }
    private function isTemplateTypeVarianceValid(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType $type) : bool
    {
        return $positionVariance->validPosition($type->getVariance());
    }
}
