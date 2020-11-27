<?php

namespace _PhpScoper26e51eeacccf;

function globalFunction1($a, $b, $c)
{
    return \false;
}
function globalFunction2($a, $b, $c) : bool
{
    $closure = function ($a, $b, $c) {
    };
    return \false;
}
/**
 * @return bool
 */
function globalFunction3($a, $b, $c)
{
    return \false;
}
namespace _PhpScoper26e51eeacccf\MissingFunctionReturnTypehint;

function namespacedFunction1($d, $e)
{
    return 9;
}
function namespacedFunction2($d, $e) : int
{
    return 9;
}
/**
 * @return int
 */
function namespacedFunction3($d, $e)
{
    return 9;
}
/**
 * @return \stdClass|array|int|null
 */
function unionTypeWithUnknownArrayValueTypehint()
{
}
/**
 * @template T
 * @template U
 */
interface GenericInterface
{
}
class NonGenericClass
{
}
function returnsGenericInterface() : \_PhpScoper26e51eeacccf\MissingFunctionReturnTypehint\GenericInterface
{
}
function returnsNonGenericClass() : \_PhpScoper26e51eeacccf\MissingFunctionReturnTypehint\NonGenericClass
{
}
/**
 * @template A
 * @template B
 */
class GenericClass
{
}
function returnsGenericClass() : \_PhpScoper26e51eeacccf\MissingFunctionReturnTypehint\GenericClass
{
}
/**
 * @return GenericClass<GenericClass<int, int>, GenericClass<int, int>>
 */
function genericGenericValidArgs() : \_PhpScoper26e51eeacccf\MissingFunctionReturnTypehint\GenericClass
{
}
/**
 * @return GenericClass<GenericClass, int>
 */
function genericGenericMissingTemplateArgs() : \_PhpScoper26e51eeacccf\MissingFunctionReturnTypehint\GenericClass
{
}
