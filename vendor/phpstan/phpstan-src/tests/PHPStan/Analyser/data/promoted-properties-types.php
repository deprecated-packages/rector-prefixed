<?php

// lint >= 8.0
namespace _PhpScoper006a73f0e455\PromotedPropertiesTypes;

use function PHPStan\Analyser\assertNativeType;
use function PHPStan\Analyser\assertType;
/**
 * @template T
 */
class Foo
{
    /**
     * @param array<int, string> $anotherPhpDocArray
     * @param T $anotherTemplateProperty
     * @param string $bothProperty
     * @param array<string> $anotherBothProperty
     */
    public function __construct(
        public $noType,
        public int $nativeIntType,
        /** @var array<int, string> */
        public $phpDocArray,
        public $anotherPhpDocArray,
        /** @var array<int, string> */
        public array $yetAnotherPhpDocArray,
        /** @var T */
        public $templateProperty,
        public $anotherTemplateProperty,
        /** @var int */
        public $bothProperty,
        /** @var array<int> */
        public $anotherBothProperty
    )
    {
        \PHPStan\Analyser\assertType('array<int, string>', $phpDocArray);
        \PHPStan\Analyser\assertNativeType('mixed', $phpDocArray);
        \PHPStan\Analyser\assertType('array<int, string>', $anotherPhpDocArray);
        \PHPStan\Analyser\assertNativeType('mixed', $anotherPhpDocArray);
        \PHPStan\Analyser\assertType('array<int, string>', $yetAnotherPhpDocArray);
        \PHPStan\Analyser\assertNativeType('array', $yetAnotherPhpDocArray);
        \PHPStan\Analyser\assertType('int', $bothProperty);
        \PHPStan\Analyser\assertType('array<int>', $anotherBothProperty);
    }
}
function (\_PhpScoper006a73f0e455\PromotedPropertiesTypes\Foo $foo) : void {
    \PHPStan\Analyser\assertType('mixed', $foo->noType);
    \PHPStan\Analyser\assertType('int', $foo->nativeIntType);
    \PHPStan\Analyser\assertType('array<int, string>', $foo->phpDocArray);
    \PHPStan\Analyser\assertType('array<int, string>', $foo->anotherPhpDocArray);
    \PHPStan\Analyser\assertType('array<int, string>', $foo->yetAnotherPhpDocArray);
    \PHPStan\Analyser\assertType('int', $foo->bothProperty);
    \PHPStan\Analyser\assertType('array<int>', $foo->anotherBothProperty);
};
/**
 * @extends Foo<\stdClass>
 */
class Bar extends \_PhpScoper006a73f0e455\PromotedPropertiesTypes\Foo
{
}
function (\_PhpScoper006a73f0e455\PromotedPropertiesTypes\Bar $bar) : void {
    \PHPStan\Analyser\assertType('stdClass', $bar->templateProperty);
    \PHPStan\Analyser\assertType('stdClass', $bar->anotherTemplateProperty);
};
/**
 * @template T
 */
class Lorem
{
    /**
     * @param T $foo
     */
    public function __construct(public $foo)
    {
    }
}
function () : void {
    $lorem = new \_PhpScoper006a73f0e455\PromotedPropertiesTypes\Lorem(new \stdClass());
    \PHPStan\Analyser\assertType('stdClass', $lorem->foo);
};
/**
 * @extends Foo<\stdClass>
 */
class Baz extends \_PhpScoper006a73f0e455\PromotedPropertiesTypes\Foo
{
    public function __construct(public $anotherPhpDocArray)
    {
        \PHPStan\Analyser\assertType('array<int, string>', $anotherPhpDocArray);
        \PHPStan\Analyser\assertNativeType('mixed', $anotherPhpDocArray);
    }
}
function (\_PhpScoper006a73f0e455\PromotedPropertiesTypes\Baz $baz) : void {
    \PHPStan\Analyser\assertType('array<int, string>', $baz->anotherPhpDocArray);
    \PHPStan\Analyser\assertType('stdClass', $baz->templateProperty);
};
