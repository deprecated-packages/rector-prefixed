<?php

namespace _PhpScoperbd5d0c5f7638\ClassAncestorsExtends;

/**
 * @template T
 * @template U of \Exception
 */
class FooGeneric
{
}
/**
 * @template T
 * @template V of \Exception
 */
class FooGeneric2
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
class FooDoesNotExtendAnything
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
class FooDuplicateExtendsTags extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
class FooWrongClassExtended extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends class-string<T>
 */
class FooWrongTypeInExtendsTag extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
class FooCorrect extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int>
 */
class FooNotEnough extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException, string>
 */
class FooExtraTypes extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \Throwable>
 */
class FooNotSubtype extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \stdClass>
 */
class FooAlsoNotSubtype extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<Zazzuuuu, \Exception>
 */
class FooUnknownClass extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Throwable
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric2 extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Exception
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric3 extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \InvalidArgumentException
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric4 extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<T, \Exception>
 */
class FooGenericGeneric5 extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<T, \Exception>
 */
class FooGenericGeneric6 extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric7 extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
class FooExtendsNonGenericClass extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooDoesNotExtendAnything
{
}
class FooExtendsGenericClass extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template-covariant T
 * @template U
 */
class FooGeneric8
{
}
/**
 * @template-covariant T
 * @extends FooGeneric8<T, T>
 */
class FooGeneric9 extends \_PhpScoperbd5d0c5f7638\ClassAncestorsExtends\FooGeneric8
{
}
