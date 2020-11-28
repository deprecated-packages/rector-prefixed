<?php

namespace _PhpScoperabd03f0baf05\ClassAncestorsExtends;

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
class FooDuplicateExtendsTags extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
class FooWrongClassExtended extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends class-string<T>
 */
class FooWrongTypeInExtendsTag extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
class FooCorrect extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int>
 */
class FooNotEnough extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException, string>
 */
class FooExtraTypes extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \Throwable>
 */
class FooNotSubtype extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \stdClass>
 */
class FooAlsoNotSubtype extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<Zazzuuuu, \Exception>
 */
class FooUnknownClass extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Throwable
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric2 extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Exception
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric3 extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \InvalidArgumentException
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric4 extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<T, \Exception>
 */
class FooGenericGeneric5 extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<T, \Exception>
 */
class FooGenericGeneric6 extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric7 extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
{
}
class FooExtendsNonGenericClass extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooDoesNotExtendAnything
{
}
class FooExtendsGenericClass extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric
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
class FooGeneric9 extends \_PhpScoperabd03f0baf05\ClassAncestorsExtends\FooGeneric8
{
}
