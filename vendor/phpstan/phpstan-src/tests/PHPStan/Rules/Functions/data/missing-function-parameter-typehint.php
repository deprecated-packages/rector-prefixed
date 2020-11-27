<?php

namespace _PhpScoper26e51eeacccf;

/**
 * @param int $a
 * @param $b
 */
function globalFunction($a, $b, $c) : bool
{
    $closure = function ($a, $b, $c) {
    };
    return \false;
}
namespace _PhpScoper26e51eeacccf\MissingFunctionParameterTypehint;

/**
 * @param $d
 */
function namespacedFunction($d, bool $e) : int
{
    return 9;
}
/**
 * @param array|int[] $a
 */
function intIterableTypehint($a)
{
}
function missingArrayTypehint(array $a)
{
}
/**
 * @param array $a
 */
function missingPhpDocIterableTypehint(array $a)
{
}
/**
 * @param mixed[] $a
 */
function explicitMixedArrayTypehint(array $a)
{
}
/**
 * @param \stdClass|array|int|null $a
 */
function unionTypeWithUnknownArrayValueTypehint($a)
{
}
/**
 * @param iterable<int>&\Traversable $a
 */
function iterableIntersectionTypehint($a)
{
}
/**
 * @param iterable<mixed>&\Traversable $a
 */
function iterableIntersectionTypehint2($a)
{
}
/**
 * @param \PDOStatement<int> $a
 */
function iterableIntersectionTypehint3($a)
{
}
/**
 * @param \PDOStatement<mixed> $a
 */
function iterableIntersectionTypehint4($a)
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
function acceptsGenericInterface(\_PhpScoper26e51eeacccf\MissingFunctionParameterTypehint\GenericInterface $i)
{
}
function acceptsNonGenericClass(\_PhpScoper26e51eeacccf\MissingFunctionParameterTypehint\NonGenericClass $c)
{
}
/**
 * @template A
 * @template B
 */
class GenericClass
{
}
function acceptsGenericClass(\_PhpScoper26e51eeacccf\MissingFunctionParameterTypehint\GenericClass $c)
{
}
function missingIterableTypehint(iterable $iterable)
{
}
/**
 * @param iterable $iterable
 */
function missingIterableTypehintPhpDoc($iterable)
{
}
function missingTraversableTypehint(\Traversable $traversable)
{
}
/**
 * @param \Traversable $traversable
 */
function missingTraversableTypehintPhpDoc($traversable)
{
}
