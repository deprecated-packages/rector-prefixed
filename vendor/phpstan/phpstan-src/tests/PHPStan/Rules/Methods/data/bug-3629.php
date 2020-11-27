<?php

namespace _PhpScoper88fe6e0ad041\Bug3629;

class HelloWorld extends \Thread
{
    public function start(int $options = \PTHREADS_INHERIT_ALL)
    {
        return parent::start($options);
    }
}
