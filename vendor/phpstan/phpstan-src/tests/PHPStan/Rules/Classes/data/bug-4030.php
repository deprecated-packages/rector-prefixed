<?php

namespace _PhpScopera143bcca66cb\Bug4011;

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
    new \_PhpScopera143bcca66cb\Bug4011\Foo($t);
};
