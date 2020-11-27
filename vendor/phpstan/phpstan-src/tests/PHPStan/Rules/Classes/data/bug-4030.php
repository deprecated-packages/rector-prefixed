<?php

namespace _PhpScoper26e51eeacccf\Bug4011;

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
    new \_PhpScoper26e51eeacccf\Bug4011\Foo($t);
};
