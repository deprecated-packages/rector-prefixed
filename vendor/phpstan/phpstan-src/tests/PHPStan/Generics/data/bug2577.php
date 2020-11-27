<?php

namespace _PhpScoperbd5d0c5f7638\Generics\Bug2577;

class A
{
}
class A1 extends \_PhpScoperbd5d0c5f7638\Generics\Bug2577\A
{
}
class A2 extends \_PhpScoperbd5d0c5f7638\Generics\Bug2577\A
{
}
/**
 * @template T of A
 *
 * @param \Closure():T $t1
 * @param T $t2
 */
function echoOneOrOther(\Closure $t1, \_PhpScoperbd5d0c5f7638\Generics\Bug2577\A $t2) : void
{
    echo \get_class($t1());
    echo \get_class($t2);
}
function test() : void
{
    echoOneOrOther(function () : A1 {
        return new \_PhpScoperbd5d0c5f7638\Generics\Bug2577\A1();
    }, new \_PhpScoperbd5d0c5f7638\Generics\Bug2577\A2());
}
