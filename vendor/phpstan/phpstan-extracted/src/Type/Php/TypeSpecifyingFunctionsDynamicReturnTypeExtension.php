<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\BrokerAwareExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class TypeSpecifyingFunctionsDynamicReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierAwareExtension, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\BrokerAwareExtension
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
    public function setBroker(\_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function setTypeSpecifier(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['array_key_exists', 'in_array', 'is_numeric', 'is_int', 'is_array', 'is_bool', 'is_callable', 'is_float', 'is_double', 'is_real', 'is_iterable', 'is_null', 'is_object', 'is_resource', 'is_scalar', 'is_string', 'is_subclass_of', 'is_countable'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if (\count($functionCall->args) === 0) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $isAlways = $this->getHelper()->findSpecifiedType($scope, $functionCall);
        if ($isAlways === null) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType($isAlways);
    }
    private function getHelper() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper
    {
        if ($this->helper === null) {
            $this->helper = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper($this->broker, $this->typeSpecifier, $this->broker->getUniversalObjectCratesClasses(), $this->treatPhpDocTypesAsCertain);
        }
        return $this->helper;
    }
}
