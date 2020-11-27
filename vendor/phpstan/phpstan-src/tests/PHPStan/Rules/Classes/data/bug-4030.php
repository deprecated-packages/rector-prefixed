<?php

namespace _PhpScoper88fe6e0ad041\Bug4011;

class Foo extends \FilterIterator
{
    public function __construct(\Traversable $iterator)
    {
    }
    public function accept()
    {
        return \true;
    }
}
function (\Traversable $t) {
    new \_PhpScoper88fe6e0ad041\Bug4011\Foo($t);
};
