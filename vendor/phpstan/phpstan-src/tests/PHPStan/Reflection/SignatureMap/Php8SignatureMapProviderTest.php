<?php

declare (strict_types=1);
namespace PHPStan\Reflection\SignatureMap;

use PHPStan\Php\PhpVersion;
use PHPStan\Php8StubsMap;
use PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher;
use PHPStan\Reflection\Native\NativeParameterReflection;
use PHPStan\Reflection\PassedByReference;
use PHPStan\Testing\TestCase;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\CallableType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FileTypeMapper;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
use PHPStan\Type\VoidType;
class Php8SignatureMapProviderTest extends \PHPStan\Testing\TestCase
{
    public function dataFunctions() : array
    {
        return [['curl_init', [['name' => 'url', 'optional' => \true, 'type' => new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\NullType()]), 'nativeType' => new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\NullType()]), 'passedByReference' => \PHPStan\Reflection\PassedByReference::createNo(), 'variadic' => \false]], new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('CurlHandle'), new \PHPStan\Type\Constant\ConstantBooleanType(\false)]), new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('CurlHandle'), new \PHPStan\Type\Constant\ConstantBooleanType(\false)]), \false], ['curl_exec', [['name' => 'handle', 'optional' => \false, 'type' => new \PHPStan\Type\ObjectType('CurlHandle'), 'nativeType' => new \PHPStan\Type\ObjectType('CurlHandle'), 'passedByReference' => \PHPStan\Reflection\PassedByReference::createNo(), 'variadic' => \false]], new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\BooleanType()]), new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\BooleanType()]), \false], ['date_get_last_errors', [], new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantBooleanType(\false), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('warning_count'), new \PHPStan\Type\Constant\ConstantStringType('warnings'), new \PHPStan\Type\Constant\ConstantStringType('error_count'), new \PHPStan\Type\Constant\ConstantStringType('errors')], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\IntegerType(), new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType())])]), new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantBooleanType(\false), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\MixedType(\true))]), \false], ['end', [['name' => 'array', 'optional' => \false, 'type' => new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), 'nativeType' => new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), 'passedByReference' => \PHPStan\Reflection\PassedByReference::createReadsArgument(), 'variadic' => \false]], new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\MixedType(\true), \false]];
    }
    /**
     * @dataProvider dataFunctions
     * @param mixed[] $parameters
     */
    public function testFunctions(string $functionName, array $parameters, \PHPStan\Type\Type $returnType, \PHPStan\Type\Type $nativeReturnType, bool $variadic) : void
    {
        $provider = $this->createProvider();
        $signature = $provider->getFunctionSignature($functionName, null);
        $this->assertSignature($parameters, $returnType, $nativeReturnType, $variadic, $signature);
    }
    private function createProvider() : \PHPStan\Reflection\SignatureMap\Php8SignatureMapProvider
    {
        return new \PHPStan\Reflection\SignatureMap\Php8SignatureMapProvider(new \PHPStan\Reflection\SignatureMap\FunctionSignatureMapProvider(self::getContainer()->getByType(\PHPStan\Reflection\SignatureMap\SignatureMapParser::class), new \PHPStan\Php\PhpVersion(80000)), self::getContainer()->getByType(\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher::class), self::getContainer()->getByType(\PHPStan\Type\FileTypeMapper::class));
    }
    public function dataMethods() : array
    {
        return [['Closure', 'bindTo', [['name' => 'newThis', 'optional' => \false, 'type' => new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\NullType()]), 'nativeType' => new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\NullType()]), 'passedByReference' => \PHPStan\Reflection\PassedByReference::createNo(), 'variadic' => \false], ['name' => 'newScope', 'optional' => \true, 'type' => new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\NullType()]), 'nativeType' => new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\NullType()]), 'passedByReference' => \PHPStan\Reflection\PassedByReference::createNo(), 'variadic' => \false]], new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('Closure'), new \PHPStan\Type\NullType()]), new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('Closure'), new \PHPStan\Type\NullType()]), \false], ['ArrayIterator', 'uasort', [['name' => 'callback', 'optional' => \false, 'type' => new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('', \false, new \PHPStan\Type\MixedType(\true), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('', \false, new \PHPStan\Type\MixedType(\true), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\IntegerType(), \false), 'nativeType' => new \PHPStan\Type\CallableType(), 'passedByReference' => \PHPStan\Reflection\PassedByReference::createNo(), 'variadic' => \false]], new \PHPStan\Type\BooleanType(), new \PHPStan\Type\MixedType(), \false], [
            'RecursiveArrayIterator',
            'uasort',
            [[
                'name' => 'cmp_function',
                'optional' => \false,
                'type' => new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('', \false, new \PHPStan\Type\MixedType(\true), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('', \false, new \PHPStan\Type\MixedType(\true), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\IntegerType(), \false),
                'nativeType' => new \PHPStan\Type\MixedType(),
                // todo - because uasort is not found in file with RecursiveArrayIterator
                'passedByReference' => \PHPStan\Reflection\PassedByReference::createNo(),
                'variadic' => \false,
            ]],
            new \PHPStan\Type\VoidType(),
            new \PHPStan\Type\MixedType(),
            // todo - because uasort is not found in file with RecursiveArrayIterator
            \false,
        ]];
    }
    /**
     * @dataProvider dataMethods
     * @param mixed[] $parameters
     */
    public function testMethods(string $className, string $methodName, array $parameters, \PHPStan\Type\Type $returnType, \PHPStan\Type\Type $nativeReturnType, bool $variadic) : void
    {
        $provider = $this->createProvider();
        $signature = $provider->getMethodSignature($className, $methodName, null);
        $this->assertSignature($parameters, $returnType, $nativeReturnType, $variadic, $signature);
    }
    /**
     * @param mixed[] $expectedParameters
     * @param Type $expectedReturnType
     * @param Type $expectedNativeReturnType
     * @param bool $expectedVariadic
     * @param FunctionSignature $actualSignature
     */
    private function assertSignature(array $expectedParameters, \PHPStan\Type\Type $expectedReturnType, \PHPStan\Type\Type $expectedNativeReturnType, bool $expectedVariadic, \PHPStan\Reflection\SignatureMap\FunctionSignature $actualSignature) : void
    {
        $this->assertCount(\count($expectedParameters), $actualSignature->getParameters());
        foreach ($expectedParameters as $i => $expectedParameter) {
            $actualParameter = $actualSignature->getParameters()[$i];
            $this->assertSame($expectedParameter['name'], $actualParameter->getName());
            $this->assertSame($expectedParameter['optional'], $actualParameter->isOptional());
            $this->assertSame($expectedParameter['type']->describe(\PHPStan\Type\VerbosityLevel::precise()), $actualParameter->getType()->describe(\PHPStan\Type\VerbosityLevel::precise()));
            $this->assertSame($expectedParameter['nativeType']->describe(\PHPStan\Type\VerbosityLevel::precise()), $actualParameter->getNativeType()->describe(\PHPStan\Type\VerbosityLevel::precise()));
            $this->assertTrue($expectedParameter['passedByReference']->equals($actualParameter->passedByReference()));
            $this->assertSame($expectedParameter['variadic'], $actualParameter->isVariadic());
        }
        $this->assertSame($expectedReturnType->describe(\PHPStan\Type\VerbosityLevel::precise()), $actualSignature->getReturnType()->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertSame($expectedNativeReturnType->describe(\PHPStan\Type\VerbosityLevel::precise()), $actualSignature->getNativeReturnType()->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertSame($expectedVariadic, $actualSignature->isVariadic());
    }
    public function dataParseAll() : array
    {
        return \array_map(static function (string $file) : array {
            return [__DIR__ . '/../../../../vendor/phpstan/php-8-stubs/' . $file];
        }, \array_merge(\PHPStan\Php8StubsMap::CLASSES, \PHPStan\Php8StubsMap::FUNCTIONS));
    }
    /**
     * @dataProvider dataParseAll
     * @param string $stubFile
     */
    public function testParseAll(string $stubFile) : void
    {
        $parser = $this->getParser();
        $parser->parseFile($stubFile);
        $this->expectNotToPerformAssertions();
    }
}
