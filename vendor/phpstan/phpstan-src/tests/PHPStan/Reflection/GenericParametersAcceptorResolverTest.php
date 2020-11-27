<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Reflection\Php\DummyParameter;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Generic\TemplateTypeFactory;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
class GenericParametersAcceptorResolverTest extends \PHPStan\Testing\TestCase
{
    /**
     * @return array<array{Type[], ParametersAcceptor, ParametersAcceptor}>
     */
    public function dataResolve() : array
    {
        $templateType = static function (string $name, ?\PHPStan\Type\Type $type = null) : Type {
            return \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), $name, $type, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return ['one param, one arg' => [[new \PHPStan\Type\ObjectType('DateTime')], new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', $templateType('T'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\NullType()), new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\ObjectType('DateTime'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\NullType())], 'two params, two args, return type' => [[new \PHPStan\Type\ObjectType('DateTime'), new \PHPStan\Type\IntegerType()], new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T'), 'U' => $templateType('U')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', $templateType('T'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Php\DummyParameter('b', $templateType('U'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, $templateType('U')), new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T'), 'U' => $templateType('U')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\ObjectType('DateTime'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Php\DummyParameter('b', new \PHPStan\Type\IntegerType(), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\IntegerType())], 'mixed types' => [[new \PHPStan\Type\ObjectType('DateTime'), new \PHPStan\Type\IntegerType()], new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', $templateType('T'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Php\DummyParameter('b', $templateType('T'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, $templateType('T')), new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('DateTime'), new \PHPStan\Type\IntegerType()]), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Php\DummyParameter('b', new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('DateTime'), new \PHPStan\Type\IntegerType()]), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('DateTime'), new \PHPStan\Type\IntegerType()]))], 'parameter default value' => [[new \PHPStan\Type\ObjectType('DateTime')], new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T'), 'U' => $templateType('U')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', $templateType('T'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Php\DummyParameter('b', $templateType('U'), \true, \PHPStan\Reflection\PassedByReference::createNo(), \false, new \PHPStan\Type\IntegerType())], \false, new \PHPStan\Type\NullType()), new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T'), 'U' => $templateType('U')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\ObjectType('DateTime'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Php\DummyParameter('b', new \PHPStan\Type\IntegerType(), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\NullType())], 'variadic parameter' => [[new \PHPStan\Type\ObjectType('DateTime'), new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2), new \PHPStan\Type\Constant\ConstantIntegerType(3)], new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T'), 'U' => $templateType('U')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', $templateType('T'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Php\DummyParameter('b', $templateType('U'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \true, null)], \true, $templateType('U')), new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T'), 'U' => $templateType('U')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\ObjectType('DateTime'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Php\DummyParameter('b', new \PHPStan\Type\IntegerType(), \false, \PHPStan\Reflection\PassedByReference::createNo(), \true, null)], \false, new \PHPStan\Type\IntegerType())], 'missing args' => [[new \PHPStan\Type\ObjectType('DateTime')], new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T'), 'U' => $templateType('U')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', $templateType('T'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Php\DummyParameter('b', $templateType('U'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\NullType()), new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T'), 'U' => $templateType('U')]), null, [new \PHPStan\Reflection\Php\DummyParameter('a', new \PHPStan\Type\ObjectType('DateTime'), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Php\DummyParameter('b', new \PHPStan\Type\MixedType(), \false, \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], \false, new \PHPStan\Type\NullType())], 'constant string arg resolved to constant string' => [[new \PHPStan\Type\Constant\ConstantStringType('foooooo')], new \PHPStan\Reflection\FunctionVariant(new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType('T')]), null, [new \PHPStan\Reflection\Php\DummyParameter('str', $templateType('T'), \false, null, \false, null)], \false, $templateType('T')), new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [new \PHPStan\Reflection\Php\DummyParameter('str', new \PHPStan\Type\StringType(), \false, null, \false, null)], \false, new \PHPStan\Type\StringType())]];
    }
    /**
     * @dataProvider dataResolve
     * @param \PHPStan\Type\Type[] $argTypes
     */
    public function testResolve(array $argTypes, \PHPStan\Reflection\ParametersAcceptor $parametersAcceptor, \PHPStan\Reflection\ParametersAcceptor $expectedResult) : void
    {
        $result = \PHPStan\Reflection\GenericParametersAcceptorResolver::resolve($argTypes, $parametersAcceptor);
        $this->assertInstanceOf(\get_class($expectedResult->getReturnType()), $result->getReturnType(), 'Unexpected return type');
        $this->assertSame($expectedResult->getReturnType()->describe(\PHPStan\Type\VerbosityLevel::precise()), $result->getReturnType()->describe(\PHPStan\Type\VerbosityLevel::precise()), 'Unexpected return type');
        $resultParameters = $result->getParameters();
        $expectedParameters = $expectedResult->getParameters();
        $this->assertCount(\count($expectedParameters), $resultParameters);
        foreach ($expectedParameters as $i => $param) {
            $this->assertInstanceOf(\get_class($param->getType()), $resultParameters[$i]->getType(), \sprintf('Unexpected parameter %d', $i + 1));
            $this->assertSame($param->getType()->describe(\PHPStan\Type\VerbosityLevel::precise()), $resultParameters[$i]->getType()->describe(\PHPStan\Type\VerbosityLevel::precise()), \sprintf('Unexpected parameter %d', $i + 1));
        }
    }
}
