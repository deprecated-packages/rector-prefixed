<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\GenericInheritance;

/**
 * interface I0
 *
 * @template T
 */
interface I0
{
}
/**
 * interface I1
 *
 * @template T
 */
interface I1
{
}
/**
 * interface I
 *
 * @template T
 *
 * @extends I0<T>
 * @extends I1<int>
 */
interface I extends \_PhpScopera143bcca66cb\GenericInheritance\I0, \_PhpScopera143bcca66cb\GenericInheritance\I1
{
}
/**
 * class C0
 *
 * @template T
 *
 * @implements I<T>
 */
class C0 implements \_PhpScopera143bcca66cb\GenericInheritance\I
{
}
/**
 * class C
 *
 * @extends C0<\DateTime>
 */
class C extends \_PhpScopera143bcca66cb\GenericInheritance\C0
{
}
/**
 * @implements I<\DateTimeInterface>
 */
class Override extends \_PhpScopera143bcca66cb\GenericInheritance\C
{
}
