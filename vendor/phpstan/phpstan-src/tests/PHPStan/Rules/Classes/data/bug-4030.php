<?php

namespace _PhpScoperabd03f0baf05\Bug4011;

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
    new \_PhpScoperabd03f0baf05\Bug4011\Foo($t);
};
