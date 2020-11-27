<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PhpParser\Node\Name;
use PHPStan\Reflection\Native\NativeParameterReflection;
use PHPStan\Reflection\Php\DummyParameter;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\FloatType;
use PHPStan\Type\Generic\TemplateTypeFactory;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ResourceType;
use PHPStan\Type\StringType;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
class ParametersAcceptorSelectorTest extends \PHPStan\Testing\TestCase
{
    public function dataSelectFromTypes() : \Generator
    {
        require_once __DIR__ . '/data/function-definitions.php';
        $broker = $this->createBroker();
        $arrayRandVariants = $broker->getFunction(new \PhpParser\Node\Name('array_rand'), null)->getVariants();
        (yield [[new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\IntegerType()], $arrayRandVariants, \false, $arrayRandVariants[0]]);
        (yield [[new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType())], $arrayRandVariants, \false, $arrayRandVariants[1]]);
        $datePeriodConstructorVariants = $broker->getClass('DatePeriod')->getNativeMethod('__construct')->getVariants();
        (yield [[new \PHPStan\Type\ObjectType(\DateTimeInterface::class), new \PHPStan\Type\ObjectType(\DateInterval::class), new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType()], $datePeriodConstructorVariants, \false, $datePeriodConstructorVariants[0]]);
        (yield [[new \PHPStan\Type\ObjectType(\DateTimeInterface::class), new \PHPStan\Type\ObjectType(\DateInterval::class), new \PHPStan\Type\ObjectType(\DateTimeInterface::class), new \PHPStan\Type\IntegerType()], $datePeriodConstructorVariants, \false, $datePeriodConstructorVariants[1]]);
        (yield [[new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()], $datePeriodConstructorVariants, \false, $datePeriodConstructorVariants[2]]);
        $ibaseWaitEventVariants = $broker->getFunction(new \PhpParser\Node\Name('ibase_wait_event'), null)->getVariants();
        (yield [[new \PHPStan\Type\ResourceType()], $ibaseWaitEventVariants, \false, $ibaseWaitEventVariants[0]]);
        (yield [[new \PHPStan\Type\StringType()], $ibaseWaitEventVariants, \false, $ibaseWaitEventVariants[1]]);
        (yield [[new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()], $ibaseWaitEventVariants, \false, new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Native\NativeParameterReflection('link_identifier|event', \false, new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('event|args', \true, new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \true, null)], \true, new \PHPStan\Type\StringType())]);
        $absVariants = $broker->getFunction(new \PhpParser\Node\Name('abs'), null)->getVariants();
        (yield [[new \PHPStan\Type\FloatType(), new \PHPStan\Type\FloatType()], $absVariants, \false, \PHPStan\Reflection\ParametersAcceptorSelector::combineAcceptors($absVariants)]);
        (yield [[new \PHPStan\Type\FloatType(), new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()], $absVariants, \false, \PHPStan\Reflection\ParametersAcceptorSelector::combineAcceptors($absVariants)]);
        (yield [[new \PHPStan\Type\StringType()], $absVariants, \false, $absVariants[2]]);
        $strtokVariants = $broker->getFunction(new \PhpParser\Node\Name('strtok'), null)->getVariants();
        (yield [[], $strtokVariants, \false, new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Native\NativeParameterReflection('str|token', \false, new \PHPStan\Type\StringType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('token', \true, new \PHPStan\Type\StringType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\Constant\ConstantBooleanType(\false)]))]);
        (yield [[new \PHPStan\Type\StringType()], $strtokVariants, \true, \PHPStan\Reflection\ParametersAcceptorSelector::combineAcceptors($strtokVariants)]);
        $variadicVariants = [new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Native\NativeParameterReflection('int', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('intVariadic', \true, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \true, null)], \true, new \PHPStan\Type\IntegerType()), new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Native\NativeParameterReflection('int', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('floatVariadic', \true, new \PHPStan\Type\FloatType(), \PHPStan\Reflection\PassedByReference::createNo(), \true, null)], \true, new \PHPStan\Type\IntegerType())];
        (yield [[new \PHPStan\Type\IntegerType()], $variadicVariants, \true, $variadicVariants[0]]);
        (yield [[new \PHPStan\Type\IntegerType()], $variadicVariants, \false, \PHPStan\Reflection\ParametersAcceptorSelector::combineAcceptors($variadicVariants)]);
        $defaultValuesVariants1 = [new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\MixedType(), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, new \PHPStan\Type\Constant\ConstantIntegerType(1))], \false, new \PHPStan\Type\NullType()), new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\MixedType(), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, new \PHPStan\Type\Constant\ConstantIntegerType(2))], \false, new \PHPStan\Type\NullType())];
        (yield [[new \PHPStan\Type\IntegerType()], $defaultValuesVariants1, \true, new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\MixedType(), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2)]))], \false, new \PHPStan\Type\NullType())]);
        $defaultValuesVariants2 = [new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\MixedType(), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, new \PHPStan\Type\Constant\ConstantIntegerType(1))], \false, new \PHPStan\Type\NullType()), new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\MixedType(), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\NullType())];
        (yield [[new \PHPStan\Type\IntegerType()], $defaultValuesVariants2, \true, new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\MixedType(), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\NullType())]);
        $genericVariants = [new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Php\DummyParameter('a', \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), 'T', null, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant()), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\NullType())];
        (yield [[new \PHPStan\Type\IntegerType()], $genericVariants, \true, new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\IntegerType(), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\NullType())]);
    }
    /**
     * @dataProvider dataSelectFromTypes
     * @param \PHPStan\Type\Type[] $types
     * @param ParametersAcceptor[] $variants
     * @param bool $unpack
     * @param ParametersAcceptor $expected
     */
    public function testSelectFromTypes(array $types, array $variants, bool $unpack, \PHPStan\Reflection\ParametersAcceptor $expected) : void
    {
        $selectedAcceptor = \PHPStan\Reflection\ParametersAcceptorSelector::selectFromTypes($types, $variants, $unpack);
        $this->assertCount(\count($expected->getParameters()), $selectedAcceptor->getParameters());
        foreach ($selectedAcceptor->getParameters() as $i => $parameter) {
            $expectedParameter = $expected->getParameters()[$i];
            $this->assertSame($expectedParameter->getName(), $parameter->getName());
            $this->assertSame($expectedParameter->isOptional(), $parameter->isOptional());
            $this->assertSame($expectedParameter->getType()->describe(\PHPStan\Type\VerbosityLevel::precise()), $parameter->getType()->describe(\PHPStan\Type\VerbosityLevel::precise()));
            $this->assertTrue($expectedParameter->passedByReference()->equals($parameter->passedByReference()));
            $this->assertSame($expectedParameter->isVariadic(), $parameter->isVariadic());
            if ($expectedParameter->getDefaultValue() === null) {
                $this->assertNull($parameter->getDefaultValue());
            } else {
                $this->assertSame($expectedParameter->getDefaultValue()->describe(\PHPStan\Type\VerbosityLevel::precise()), $parameter->getDefaultValue() !== null ? $parameter->getDefaultValue()->describe(\PHPStan\Type\VerbosityLevel::precise()) : null);
            }
        }
        $this->assertSame($expected->getReturnType()->describe(\PHPStan\Type\VerbosityLevel::precise()), $selectedAcceptor->getReturnType()->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertSame($expected->isVariadic(), $selectedAcceptor->isVariadic());
    }
}
