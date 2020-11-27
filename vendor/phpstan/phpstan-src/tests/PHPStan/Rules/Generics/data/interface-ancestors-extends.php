<?php

namespace _PhpScoper88fe6e0ad041\InterfaceAncestorsExtends;

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
interface FooInvalidImplementsTags extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
interface FooWrongClassImplemented extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric, \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric3
{
}
/**
 * @extends class-string<T>
 */
interface FooWrongTypeInImplementsTag extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
interface FooCorrect extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int>
 */
interface FooNotEnough extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException, string>
 */
interface FooExtraTypes extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \Throwable>
 */
interface FooNotSubtype extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \stdClass>
 */
interface FooAlsoNotSubtype extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<Zazzuuuu, \Exception>
 */
interface FooUnknowninterface extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Throwable
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric2 extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Exception
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric3 extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \InvalidArgumentException
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric4 extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<T, \Exception>
 */
interface FooGenericGeneric5 extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<T, \Exception>
 */
interface FooGenericGeneric6 extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric7 extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 * @extends FooGeneric2<int, T>
 */
interface FooGenericGeneric8 extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric, \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric2
{
}
interface NonGenericInterface
{
}
interface ExtendsNonGenericInterface extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\NonGenericInterface
{
}
interface ExtendsGenericInterface extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric
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
interface FooGeneric10 extends \_PhpScoper88fe6e0ad041\InterfaceAncestorsExtends\FooGeneric9
{
}
