<?php

declare (strict_types=1);
namespace PHPStan;

class TrinaryLogicTest extends \PHPStan\Testing\TestCase
{
    public function dataAnd() : array
    {
        return [[\PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createNo()], [\PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe()], [\PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes()], [\PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createNo()], [\PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createMaybe()], [\PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createYes()], [\PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createNo()], [\PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe()], [\PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createYes()], [\PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createNo()], [\PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createMaybe()], [\PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataAnd
     * @param TrinaryLogic $expectedResult
     * @param TrinaryLogic $value
     * @param TrinaryLogic ...$operands
     */
    public function testAnd(\PHPStan\TrinaryLogic $expectedResult, \PHPStan\TrinaryLogic $value, \PHPStan\TrinaryLogic ...$operands) : void
    {
        $this->assertTrue($expectedResult->equals($value->and(...$operands)));
    }
    public function dataOr() : array
    {
        return [[\PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createNo()], [\PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe()], [\PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes()], [\PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createNo()], [\PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createMaybe()], [\PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createYes()], [\PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createNo()], [\PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe()], [\PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createYes()], [\PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createNo()], [\PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createMaybe()], [\PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataOr
     * @param TrinaryLogic $expectedResult
     * @param TrinaryLogic $value
     * @param TrinaryLogic ...$operands
     */
    public function testOr(\PHPStan\TrinaryLogic $expectedResult, \PHPStan\TrinaryLogic $value, \PHPStan\TrinaryLogic ...$operands) : void
    {
        $this->assertTrue($expectedResult->equals($value->or(...$operands)));
    }
    public function dataNegate() : array
    {
        return [[\PHPStan\TrinaryLogic::createNo(), \PHPStan\TrinaryLogic::createYes()], [\PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe()], [\PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataNegate
     * @param TrinaryLogic $expectedResult
     * @param TrinaryLogic $operand
     */
    public function testNegate(\PHPStan\TrinaryLogic $expectedResult, \PHPStan\TrinaryLogic $operand) : void
    {
        $this->assertTrue($expectedResult->equals($operand->negate()));
    }
    public function dataCompareTo() : array
    {
        $yes = \PHPStan\TrinaryLogic::createYes();
        $maybe = \PHPStan\TrinaryLogic::createMaybe();
        $no = \PHPStan\TrinaryLogic::createNo();
        return [[$yes, $yes, null], [$maybe, $maybe, null], [$no, $no, null], [$yes, $maybe, $yes], [$yes, $no, $yes], [$maybe, $no, $maybe]];
    }
    /**
     * @dataProvider dataCompareTo
     * @param TrinaryLogic $first
     * @param TrinaryLogic $second
     * @param TrinaryLogic|null $expected
     */
    public function testCompareTo(\PHPStan\TrinaryLogic $first, \PHPStan\TrinaryLogic $second, ?\PHPStan\TrinaryLogic $expected) : void
    {
        $this->assertSame($expected, $first->compareTo($second));
    }
    /**
     * @dataProvider dataCompareTo
     * @param TrinaryLogic $first
     * @param TrinaryLogic $second
     * @param TrinaryLogic|null $expected
     */
    public function testCompareToInversed(\PHPStan\TrinaryLogic $first, \PHPStan\TrinaryLogic $second, ?\PHPStan\TrinaryLogic $expected) : void
    {
        $this->assertSame($expected, $second->compareTo($first));
    }
}
