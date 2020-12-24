<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\BrokerAwareExtension;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class TypeSpecifyingFunctionsDynamicReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension, \_PhpScoperb75b35f52b74\PHPStan\Reflection\BrokerAwareExtension
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
    public function setBroker(\_PhpScoperb75b35f52b74\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function setTypeSpecifier(\_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['array_key_exists', 'in_array', 'is_numeric', 'is_int', 'is_array', 'is_bool', 'is_callable', 'is_float', 'is_double', 'is_real', 'is_iterable', 'is_null', 'is_object', 'is_resource', 'is_scalar', 'is_string', 'is_subclass_of', 'is_countable'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (\count($functionCall->args) === 0) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $isAlways = $this->getHelper()->findSpecifiedType($scope, $functionCall);
        if ($isAlways === null) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType($isAlways);
    }
    private function getHelper() : \_PhpScoperb75b35f52b74\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper
    {
        if ($this->helper === null) {
            $this->helper = new \_PhpScoperb75b35f52b74\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper($this->broker, $this->typeSpecifier, $this->broker->getUniversalObjectCratesClasses(), $this->treatPhpDocTypesAsCertain);
        }
        return $this->helper;
    }
}
