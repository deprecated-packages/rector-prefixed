<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareExtension;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\Type;
class TypeSpecifyingFunctionsDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension, \PHPStan\Analyser\TypeSpecifierAwareExtension, \PHPStan\Reflection\BrokerAwareExtension
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
    public function setBroker(\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function setTypeSpecifier(\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['array_key_exists', 'in_array', 'is_numeric', 'is_int', 'is_array', 'is_bool', 'is_callable', 'is_float', 'is_double', 'is_real', 'is_iterable', 'is_null', 'is_object', 'is_resource', 'is_scalar', 'is_string', 'is_subclass_of', 'is_countable'], \true);
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($functionCall->args) === 0) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $isAlways = $this->getHelper()->findSpecifiedType($scope, $functionCall);
        if ($isAlways === null) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        return new \PHPStan\Type\Constant\ConstantBooleanType($isAlways);
    }
    private function getHelper() : \PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper
    {
        if ($this->helper === null) {
            $this->helper = new \PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper($this->broker, $this->typeSpecifier, $this->broker->getUniversalObjectCratesClasses(), $this->treatPhpDocTypesAsCertain);
        }
        return $this->helper;
    }
}
