<?php

namespace _PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends;

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
interface FooInvalidImplementsTags extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
interface FooWrongClassImplemented extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric, \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric3
{
}
/**
 * @extends class-string<T>
 */
interface FooWrongTypeInImplementsTag extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
interface FooCorrect extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int>
 */
interface FooNotEnough extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException, string>
 */
interface FooExtraTypes extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \Throwable>
 */
interface FooNotSubtype extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \stdClass>
 */
interface FooAlsoNotSubtype extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<Zazzuuuu, \Exception>
 */
interface FooUnknowninterface extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Throwable
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric2 extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Exception
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric3 extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \InvalidArgumentException
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric4 extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<T, \Exception>
 */
interface FooGenericGeneric5 extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<T, \Exception>
 */
interface FooGenericGeneric6 extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 */
interface FooGenericGeneric7 extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 * @extends FooGeneric2<int, T>
 */
interface FooGenericGeneric8 extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric, \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric2
{
}
interface NonGenericInterface
{
}
interface ExtendsNonGenericInterface extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\NonGenericInterface
{
}
interface ExtendsGenericInterface extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric
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
interface FooGeneric10 extends \_PhpScoperbd5d0c5f7638\InterfaceAncestorsExtends\FooGeneric9
{
}
