<?php

namespace _PhpScopera143bcca66cb\Bug2677;

use function PHPStan\Analyser\assertType;
class A
{
}
class B
{
}
class C
{
}
class D
{
}
class E
{
}
class F
{
}
class G
{
}
class H
{
}
class I
{
}
class J
{
}
class K
{
}
class L
{
}
class M
{
}
class N
{
}
class O
{
}
class P
{
}
function () {
    $classes = [\_PhpScopera143bcca66cb\Bug2677\A::class, \_PhpScopera143bcca66cb\Bug2677\B::class, \_PhpScopera143bcca66cb\Bug2677\C::class, \_PhpScopera143bcca66cb\Bug2677\D::class, \_PhpScopera143bcca66cb\Bug2677\E::class, \_PhpScopera143bcca66cb\Bug2677\F::class, \_PhpScopera143bcca66cb\Bug2677\G::class, \_PhpScopera143bcca66cb\Bug2677\H::class, \_PhpScopera143bcca66cb\Bug2677\I::class, \_PhpScopera143bcca66cb\Bug2677\J::class, \_PhpScopera143bcca66cb\Bug2677\K::class, \_PhpScopera143bcca66cb\Bug2677\L::class, \_PhpScopera143bcca66cb\Bug2677\M::class, \_PhpScopera143bcca66cb\Bug2677\N::class, \_PhpScopera143bcca66cb\Bug2677\O::class, \_PhpScopera143bcca66cb\Bug2677\P::class];
    \PHPStan\Analyser\assertType('array(\'Bug2677\\\\A\', \'Bug2677\\\\B\', \'Bug2677\\\\C\', \'Bug2677\\\\D\', \'Bug2677\\\\E\', \'Bug2677\\\\F\', \'Bug2677\\\\G\', \'Bug2677\\\\H\', \'Bug2677\\\\I\', \'Bug2677\\\\J\', \'Bug2677\\\\K\', \'Bug2677\\\\L\', \'Bug2677\\\\M\', \'Bug2677\\\\N\', \'Bug2677\\\\O\', \'Bug2677\\\\P\')', $classes);
    foreach ($classes as $class) {
        \PHPStan\Analyser\assertType('class-string', $class);
    }
};
