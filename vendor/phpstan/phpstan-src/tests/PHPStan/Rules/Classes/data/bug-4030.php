<?php

namespace _PhpScoperbd5d0c5f7638\Bug4011;

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
    new \_PhpScoperbd5d0c5f7638\Bug4011\Foo($t);
};
