<?php

namespace _PhpScoperbd5d0c5f7638;

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
namespace _PhpScoperbd5d0c5f7638\MissingFunctionReturnTypehint;

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
function returnsGenericInterface() : \_PhpScoperbd5d0c5f7638\MissingFunctionReturnTypehint\GenericInterface
{
}
function returnsNonGenericClass() : \_PhpScoperbd5d0c5f7638\MissingFunctionReturnTypehint\NonGenericClass
{
}
/**
 * @template A
 * @template B
 */
class GenericClass
{
}
function returnsGenericClass() : \_PhpScoperbd5d0c5f7638\MissingFunctionReturnTypehint\GenericClass
{
}
/**
 * @return GenericClass<GenericClass<int, int>, GenericClass<int, int>>
 */
function genericGenericValidArgs() : \_PhpScoperbd5d0c5f7638\MissingFunctionReturnTypehint\GenericClass
{
}
/**
 * @return GenericClass<GenericClass, int>
 */
function genericGenericMissingTemplateArgs() : \_PhpScoperbd5d0c5f7638\MissingFunctionReturnTypehint\GenericClass
{
}
