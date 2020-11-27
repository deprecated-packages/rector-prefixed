<?php

declare (strict_types=1);
namespace PHPStan\Analyser;

use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\Testing\TestCase;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
class ScopeTest extends \PHPStan\Testing\TestCase
{
    public function dataGeneralize() : array
    {
        return [[new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('a'), '\'a\''], [new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b'), 'string'], [new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1), 'int'], [new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)]), new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2)]), 'int'], [new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantStringType('foo')]), new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantStringType('foo')]), '0|1|\'foo\''], [new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantStringType('foo')]), new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2), new \PHPStan\Type\Constant\ConstantStringType('foo')]), '\'foo\'|int'], [new \PHPStan\Type\Constant\ConstantBooleanType(\false), new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('Foo'), new \PHPStan\Type\Constant\ConstantBooleanType(\false)]), 'Foo|false'], [new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('Foo'), new \PHPStan\Type\Constant\ConstantBooleanType(\false)]), new \PHPStan\Type\Constant\ConstantBooleanType(\false), 'Foo|false'], [new \PHPStan\Type\ObjectType('Foo'), new \PHPStan\Type\Constant\ConstantBooleanType(\false), 'Foo'], [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a')], [new \PHPStan\Type\Constant\ConstantIntegerType(1)]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a')], [new \PHPStan\Type\Constant\ConstantIntegerType(1)]), 'array(\'a\' => 1)'], [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(1)]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [new \PHPStan\Type\Constant\ConstantIntegerType(2), new \PHPStan\Type\Constant\ConstantIntegerType(1)]), 'array(\'a\' => int, \'b\' => 1)'], [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a')], [new \PHPStan\Type\Constant\ConstantIntegerType(1)]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(1)]), 'array<string, 1>'], [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a')], [new \PHPStan\Type\Constant\ConstantIntegerType(1)]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2)]), 'array<string, int>']];
    }
    /**
     * @dataProvider dataGeneralize
     * @param Type $a
     * @param Type $b
     * @param string $expectedTypeDescription
     */
    public function testGeneralize(\PHPStan\Type\Type $a, \PHPStan\Type\Type $b, string $expectedTypeDescription) : void
    {
        /** @var ScopeFactory $scopeFactory */
        $scopeFactory = self::getContainer()->getByType(\PHPStan\Analyser\ScopeFactory::class);
        $scopeA = $scopeFactory->create(\PHPStan\Analyser\ScopeContext::create('file.php'))->assignVariable('a', $a);
        $scopeB = $scopeFactory->create(\PHPStan\Analyser\ScopeContext::create('file.php'))->assignVariable('a', $b);
        $resultScope = $scopeA->generalizeWith($scopeB);
        $this->assertSame($expectedTypeDescription, $resultScope->getVariableType('a')->describe(\PHPStan\Type\VerbosityLevel::precise()));
    }
    public function testGetConstantType() : void
    {
        /** @var ScopeFactory $scopeFactory */
        $scopeFactory = self::getContainer()->getByType(\PHPStan\Analyser\ScopeFactory::class);
        $scope = $scopeFactory->create(\PHPStan\Analyser\ScopeContext::create(__DIR__ . '/data/compiler-halt-offset.php'));
        $node = new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name\FullyQualified('__COMPILER_HALT_OFFSET__'));
        $type = $scope->getType($node);
        $this->assertSame('int', $type->describe(\PHPStan\Type\VerbosityLevel::precise()));
    }
}
