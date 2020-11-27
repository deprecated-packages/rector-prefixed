<?php

namespace _PhpScoper26e51eeacccf\Generics\Bug2577;

class A
{
}
class A1 extends \_PhpScoper26e51eeacccf\Generics\Bug2577\A
{
}
class A2 extends \_PhpScoper26e51eeacccf\Generics\Bug2577\A
{
}
/**
 * @template T of A
 *
 * @param \Closure():T $t1
 * @param T $t2
 */
function echoOneOrOther(\Closure $t1, \_PhpScoper26e51eeacccf\Generics\Bug2577\A $t2) : void
{
    echo \get_class($t1());
    echo \get_class($t2);
}
function test() : void
{
    echoOneOrOther(function () : A1 {
        return new \_PhpScoper26e51eeacccf\Generics\Bug2577\A1();
    }, new \_PhpScoper26e51eeacccf\Generics\Bug2577\A2());
}
