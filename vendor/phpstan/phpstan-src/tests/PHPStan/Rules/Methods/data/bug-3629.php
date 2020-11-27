<?php

namespace _PhpScoperbd5d0c5f7638\Bug3629;

class HelloWorld extends \Thread
{
    public function start(int $options = \PTHREADS_INHERIT_ALL)
    {
        return parent::start($options);
    }
}
