<?php

namespace _PhpScoper006a73f0e455\ClassAncestorsExtends;

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
class FooDuplicateExtendsTags extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric2<int, \InvalidArgumentException>
 */
class FooWrongClassExtended extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends class-string<T>
 */
class FooWrongTypeInExtendsTag extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException>
 */
class FooCorrect extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int>
 */
class FooNotEnough extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \InvalidArgumentException, string>
 */
class FooExtraTypes extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \Throwable>
 */
class FooNotSubtype extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<int, \stdClass>
 */
class FooAlsoNotSubtype extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @extends FooGeneric<Zazzuuuu, \Exception>
 */
class FooUnknownClass extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Throwable
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric2 extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \Exception
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric3 extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \InvalidArgumentException
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric4 extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T
 * @extends FooGeneric<T, \Exception>
 */
class FooGenericGeneric5 extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<T, \Exception>
 */
class FooGenericGeneric6 extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
/**
 * @template T of \stdClass
 * @extends FooGeneric<int, T>
 */
class FooGenericGeneric7 extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
{
}
class FooExtendsNonGenericClass extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooDoesNotExtendAnything
{
}
class FooExtendsGenericClass extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric
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
class FooGeneric9 extends \_PhpScoper006a73f0e455\ClassAncestorsExtends\FooGeneric8
{
}
