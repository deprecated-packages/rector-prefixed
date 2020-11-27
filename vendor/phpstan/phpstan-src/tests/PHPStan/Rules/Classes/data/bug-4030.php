<?php

namespace _PhpScoper006a73f0e455\Bug4011;

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
    new \_PhpScoper006a73f0e455\Bug4011\Foo($t);
};
