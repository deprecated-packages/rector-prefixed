<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\Reflection\BrokerAwareExtension;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class TypeSpecifyingFunctionsDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension, \_PhpScopere8e811afab72\PHPStan\Reflection\BrokerAwareExtension
{
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    /** @var \PHPStan\Broker\Broker */
    private $broker;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    /** @var \PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper|null */
    private $helper = null;
    public function __construct(bool $treatPhpDocTypesAsCertain)
    {
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function setBroker(\_PhpScopere8e811afab72\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function setTypeSpecifier(\_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['array_key_exists', 'in_array', 'is_numeric', 'is_int', 'is_array', 'is_bool', 'is_callable', 'is_float', 'is_double', 'is_real', 'is_iterable', 'is_null', 'is_object', 'is_resource', 'is_scalar', 'is_string', 'is_subclass_of', 'is_countable'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\count($functionCall->args) === 0) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $isAlways = $this->getHelper()->findSpecifiedType($scope, $functionCall);
        if ($isAlways === null) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType($isAlways);
    }
    private function getHelper() : \_PhpScopere8e811afab72\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper
    {
        if ($this->helper === null) {
            $this->helper = new \_PhpScopere8e811afab72\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper($this->broker, $this->typeSpecifier, $this->broker->getUniversalObjectCratesClasses(), $this->treatPhpDocTypesAsCertain);
        }
        return $this->helper;
    }
}
