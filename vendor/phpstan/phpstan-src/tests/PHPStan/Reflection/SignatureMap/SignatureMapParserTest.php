<?php

declare (strict_types=1);
namespace PHPStan\Reflection\SignatureMap;

use PHPStan\Php\PhpVersion;
use PHPStan\Reflection\PassedByReference;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\CallableType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ResourceType;
use PHPStan\Type\StaticType;
use PHPStan\Type\StringType;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
class SignatureMapParserTest extends \PHPStan\Testing\TestCase
{
    public function dataGetFunctions() : array
    {
        return [[['int', 'fp' => 'resource', 'fields' => 'array', 'delimiter=' => 'string', 'enclosure=' => 'string', 'escape_char=' => 'string'], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([new \PHPStan\Reflection\SignatureMap\ParameterSignature('fp', \false, new \PHPStan\Type\ResourceType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('fields', \false, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('delimiter', \true, new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('enclosure', \true, new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('escape_char', \true, new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false)], new \PHPStan\Type\IntegerType(), new \PHPStan\Type\MixedType(), \false)], [['bool', 'fp' => 'resource'], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([new \PHPStan\Reflection\SignatureMap\ParameterSignature('fp', \false, new \PHPStan\Type\ResourceType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false)], new \PHPStan\Type\BooleanType(), new \PHPStan\Type\MixedType(), \false)], [['bool', '&rw_array_arg' => 'array'], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([new \PHPStan\Reflection\SignatureMap\ParameterSignature('array_arg', \false, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createReadsArgument(), \false)], new \PHPStan\Type\BooleanType(), new \PHPStan\Type\MixedType(), \false)], [['bool', 'csr' => 'string|resource', '&w_out' => 'string', 'notext=' => 'bool'], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([new \PHPStan\Reflection\SignatureMap\ParameterSignature('csr', \false, new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\ResourceType()]), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('out', \false, new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createCreatesNewVariable(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('notext', \true, new \PHPStan\Type\BooleanType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false)], new \PHPStan\Type\BooleanType(), new \PHPStan\Type\MixedType(), \false)], [['(?Throwable)|(?Foo)'], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([], new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType(\Throwable::class), new \PHPStan\Type\ObjectType('Foo'), new \PHPStan\Type\NullType()]), new \PHPStan\Type\MixedType(), \false)], [[''], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([], new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType(), \false)], [['array', 'arr1' => 'array', 'arr2' => 'array', '...=' => 'array'], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([new \PHPStan\Reflection\SignatureMap\ParameterSignature('arr1', \false, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('arr2', \false, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('...', \true, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \true)], new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\MixedType(), \true)], [['resource', 'callback' => 'callable', 'event' => 'string', '...' => ''], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([new \PHPStan\Reflection\SignatureMap\ParameterSignature('callback', \false, new \PHPStan\Type\CallableType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('event', \false, new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('...', \true, new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \true)], new \PHPStan\Type\ResourceType(), new \PHPStan\Type\MixedType(), \true)], [['string', 'format' => 'string', '...args=' => ''], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([new \PHPStan\Reflection\SignatureMap\ParameterSignature('format', \false, new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('args', \true, new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \true)], new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType(), \true)], [['string', 'format' => 'string', '...args' => ''], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([new \PHPStan\Reflection\SignatureMap\ParameterSignature('format', \false, new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('args', \true, new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \true)], new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType(), \true)], [['array<int,ReflectionParameter>'], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([], new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\ObjectType(\ReflectionParameter::class)), new \PHPStan\Type\MixedType(), \false)], [['static', 'interval' => 'DateInterval'], \DateTime::class, new \PHPStan\Reflection\SignatureMap\FunctionSignature([new \PHPStan\Reflection\SignatureMap\ParameterSignature('interval', \false, new \PHPStan\Type\ObjectType(\DateInterval::class), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false)], new \PHPStan\Type\StaticType(\DateTime::class), new \PHPStan\Type\MixedType(), \false)], [['bool', '&rw_string' => 'string', '&...rw_strings=' => 'string'], null, new \PHPStan\Reflection\SignatureMap\FunctionSignature([new \PHPStan\Reflection\SignatureMap\ParameterSignature('string', \false, new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createReadsArgument(), \false), new \PHPStan\Reflection\SignatureMap\ParameterSignature('strings', \true, new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createReadsArgument(), \true)], new \PHPStan\Type\BooleanType(), new \PHPStan\Type\MixedType(), \true)]];
    }
    /**
     * @dataProvider dataGetFunctions
     * @param mixed[] $map
     * @param string|null $className
     * @param \PHPStan\Reflection\SignatureMap\FunctionSignature $expectedSignature
     */
    public function testGetFunctions(array $map, ?string $className, \PHPStan\Reflection\SignatureMap\FunctionSignature $expectedSignature) : void
    {
        /** @var SignatureMapParser $parser */
        $parser = self::getContainer()->getByType(\PHPStan\Reflection\SignatureMap\SignatureMapParser::class);
        $functionSignature = $parser->getFunctionSignature($map, $className);
        $this->assertCount(\count($expectedSignature->getParameters()), $functionSignature->getParameters(), 'Number of parameters does not match.');
        foreach ($functionSignature->getParameters() as $i => $parameterSignature) {
            $expectedParameterSignature = $expectedSignature->getParameters()[$i];
            $this->assertSame($expectedParameterSignature->getName(), $parameterSignature->getName(), \sprintf('Name of parameter #%d does not match.', $i));
            $this->assertSame($expectedParameterSignature->isOptional(), $parameterSignature->isOptional(), \sprintf('Optionality of parameter $%s does not match.', $parameterSignature->getName()));
            $this->assertSame($expectedParameterSignature->getType()->describe(\PHPStan\Type\VerbosityLevel::precise()), $parameterSignature->getType()->describe(\PHPStan\Type\VerbosityLevel::precise()), \sprintf('Type of parameter $%s does not match.', $parameterSignature->getName()));
            $this->assertTrue($expectedParameterSignature->passedByReference()->equals($parameterSignature->passedByReference()), \sprintf('Passed-by-reference of parameter $%s does not match.', $parameterSignature->getName()));
            $this->assertSame($expectedParameterSignature->isVariadic(), $parameterSignature->isVariadic(), \sprintf('Variadicity of parameter $%s does not match.', $parameterSignature->getName()));
        }
        $this->assertSame($expectedSignature->getReturnType()->describe(\PHPStan\Type\VerbosityLevel::precise()), $functionSignature->getReturnType()->describe(\PHPStan\Type\VerbosityLevel::precise()), 'Return type does not match.');
        $this->assertSame($expectedSignature->isVariadic(), $functionSignature->isVariadic(), 'Variadicity does not match.');
    }
    public function dataParseAll() : array
    {
        return [[70400], [80000]];
    }
    /**
     * @dataProvider dataParseAll
     * @param int $phpVersionId
     */
    public function testParseAll(int $phpVersionId) : void
    {
        $parser = self::getContainer()->getByType(\PHPStan\Reflection\SignatureMap\SignatureMapParser::class);
        $provider = new \PHPStan\Reflection\SignatureMap\FunctionSignatureMapProvider($parser, new \PHPStan\Php\PhpVersion($phpVersionId));
        $signatureMap = $provider->getSignatureMap();
        $count = 0;
        foreach (\array_keys($signatureMap) as $functionName) {
            $className = null;
            if (\strpos($functionName, '::') !== \false) {
                $parts = \explode('::', $functionName);
                $className = $parts[0];
            }
            try {
                $signature = $provider->getFunctionSignature($functionName, $className);
                $count++;
            } catch (\PHPStan\PhpDocParser\Parser\ParserException $e) {
                $this->fail(\sprintf('Could not parse %s: %s.', $functionName, $e->getMessage()));
            }
            self::assertNotInstanceOf(\PHPStan\Type\ErrorType::class, $signature->getReturnType(), $functionName);
            $optionalOcurred = \false;
            foreach ($signature->getParameters() as $parameter) {
                if ($parameter->isOptional()) {
                    $optionalOcurred = \true;
                } elseif ($optionalOcurred) {
                    $this->fail(\sprintf('%s contains required parameter after optional.', $functionName));
                }
                self::assertNotInstanceOf(\PHPStan\Type\ErrorType::class, $parameter->getType(), \sprintf('%s (parameter %s)', $functionName, $parameter->getName()));
            }
        }
        $this->assertGreaterThan(0, $count);
    }
}
