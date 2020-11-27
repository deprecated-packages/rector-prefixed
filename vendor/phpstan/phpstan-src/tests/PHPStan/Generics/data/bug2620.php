<?php

namespace _PhpScoper88fe6e0ad041\Generics\Bug2620;

class Foo
{
    public function someMethod() : void
    {
    }
}
class Bar
{
}
/**
 * @implements \IteratorAggregate<int, Foo>
 */
class SomeIterator implements \IteratorAggregate
{
    /**
     * @return \Traversable<int, Bar>
     */
    public function getIterator()
    {
        (yield new \_PhpScoper88fe6e0ad041\Generics\Bug2620\Bar());
    }
}
/**
 * @param \IteratorAggregate<int, Foo> $i
 */
function takesIteratorAggregate(\IteratorAggregate $i) : void
{
    foreach ($i as $foo) {
        $foo->someMethod();
    }
}
function test() : void
{
    takesIteratorAggregate(new \_PhpScoper88fe6e0ad041\Generics\Bug2620\SomeIterator());
}
