<?php

namespace _PhpScoper88fe6e0ad041\IssetRule;

class FooCoalesce
{
    /** @var string|null */
    public static $staticStringOrNull = null;
    /** @var string */
    public static $staticString = '';
    /** @var null */
    public static $staticAlwaysNull;
    /** @var string|null */
    public $stringOrNull = null;
    /** @var string */
    public $string = '';
    /** @var null */
    public $alwaysNull;
    /** @var FooCoalesce|null */
    public $fooCoalesceOrNull;
    /** @var FooCoalesce */
    public $fooCoalesce;
    public function thisCoalesce()
    {
        echo isset($this->string) ? $this->string : null;
    }
}
function coalesce()
{
    $scalar = 3;
    echo isset($scalar) ? $scalar : 4;
    $array = [1, 2, 3];
    echo isset($array['string']) ? $array['string'] : 0;
    $multiDimArray = [[1], [2], [3]];
    echo isset($multiDimArray['string']) ? $multiDimArray['string'] : 0;
    echo isset($doesNotExist) ? $doesNotExist : 0;
    if (\rand() > 0.5) {
        $maybeVariable = 3;
    }
    echo isset($maybeVariable) ? $maybeVariable : 0;
    $fixedDimArray = ['dim' => 1, 'dim-null' => \rand() > 0.5 ? null : 1, 'dim-null-offset' => ['a' => \rand() > 0.5 ? \true : null], 'dim-empty' => []];
    // Always set
    echo isset($fixedDimArray['dim']) ? $fixedDimArray['dim'] : 0;
    // Maybe set
    echo isset($fixedDimArray['dim-null']) ? $fixedDimArray['dim-null'] : 0;
    // Never set, then unknown
    echo isset($fixedDimArray['dim-null-not-set']['a']) ? $fixedDimArray['dim-null-not-set']['a'] : 0;
    // Always set, then always set
    echo isset($fixedDimArray['dim-null-offset']['a']) ? $fixedDimArray['dim-null-offset']['a'] : 0;
    // Always set, then never set
    echo isset($fixedDimArray['dim-empty']['b']) ? $fixedDimArray['dim-empty']['b'] : 0;
    $foo = new \_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce();
    echo isset($foo->stringOrNull) ? $foo->stringOrNull : '';
    echo isset($foo->string) ? $foo->string : '';
    echo isset($foo->alwaysNull) ? $foo->alwaysNull : '';
    echo isset($foo->fooCoalesce->string) ? $foo->fooCoalesce->string : '';
    echo isset($foo->fooCoalesceOrNull->string) ? $foo->fooCoalesceOrNull->string : '';
    echo isset(\_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce::$staticStringOrNull) ? \_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce::$staticStringOrNull : '';
    echo isset(\_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce::$staticString) ? \_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce::$staticString : '';
    echo isset(\_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce::$staticAlwaysNull) ? \_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce::$staticAlwaysNull : '';
}
/**
 * @param array<string, int> $array
 */
function coalesceStringOffset(array $array)
{
    echo isset($array['string']) ? $array['string'] : 0;
}
function alwaysNullCoalesce(?string $a) : void
{
    if (!\is_string($a)) {
        echo isset($a) ? $a : 'foo';
    }
}
function () : void {
    echo isset((new \_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce())->string) ? (new \_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce())->string : 'foo';
    echo isset((new \_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce())->stringOrNull) ? (new \_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce())->stringOrNull : 'foo';
    echo isset((new \_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce())->alwaysNull) ? (new \_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce())->alwaysNull : 'foo';
};
function (\_PhpScoper88fe6e0ad041\IssetRule\FooCoalesce $foo) : void {
    echo isset($foo::$staticAlwaysNull) ? $foo::$staticAlwaysNull : 'foo';
    echo isset($foo::$staticString) ? $foo::$staticString : 'foo';
    echo isset($foo::$staticStringOrNull) ? $foo::$staticStringOrNull : 'foo';
};
/**
 * @property int $integerProperty
 * @property FooCoalesce $foo
 */
class SomeMagicProperties
{
}
function (\_PhpScoper88fe6e0ad041\IssetRule\SomeMagicProperties $foo, \stdClass $std) : void {
    echo isset($foo->integerProperty) ? $foo->integerProperty : null;
    echo isset($foo->foo->string) ? $foo->foo->string : null;
    echo isset($std->foo) ? $std->foo : null;
};
function numericStringOffset(string $code) : string
{
    $array = [1, 2, 3];
    if (isset($array[$code])) {
        return (string) $array[$code];
    }
    $mappings = ['21021200' => '21028800'];
    if (isset($mappings[$code])) {
        return (string) $mappings[$code];
    }
    throw new \RuntimeException();
}
