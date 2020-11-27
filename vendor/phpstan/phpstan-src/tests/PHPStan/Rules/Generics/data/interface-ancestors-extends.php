<?php

namespace _PhpScopera143bcca66cb\InterfaceAncestorsExtends;

/**
 * @template T
 * @template U of \Exception
 */
interface FooGeneric
{
}
/**
 * @template T
 * @template V of \Exception
 */
interface FooGeneric2
{
}
/**
 * @template T
 * @template W of \Exception
 */
interface FooGeneric3
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
interface FooDoesNotImplementAnything
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
interface FooInvalidImplementsTags extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
interface FooWrongClassImplemented extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric, \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric3
{
}
/**
 * @extends class-string<T>
 */
interface FooWrongTypeInImplementsTag extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
interface FooCorrect extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int>
 */
interface FooNotEnough extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException, string>
 */
interface FooExtraTypes extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \Throwable>
 */
interface FooNotSubtype extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \stdClass>
 */
interface FooAlsoNotSubtype extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<Zazzuuuu, \Exception>
 */
interface FooUnknowninterface extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Throwable
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric2 extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Exception
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric3 extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \InvalidArgumentException
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric4 extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<T, \Exception>
 */
interface FooGenericGeneric5 extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<T, \Exception>
 */
interface FooGenericGeneric6 extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric7 extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 * @extends FooGeneric2<int, T>
 */
interface FooGenericGeneric8 extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric, \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric2
{
}
interface NonGenericInterface
{
}
interface ExtendsNonGenericInterface extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\NonGenericInterface
{
}
interface ExtendsGenericInterface extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template-covariant T
 * @template U
 */
interface FooGeneric9
{
}
/**
 * @template-covariant T
 * @extends FooGeneric9<T, T>
 */
interface FooGeneric10 extends \_PhpScopera143bcca66cb\InterfaceAncestorsExtends\FooGeneric9
{
}
