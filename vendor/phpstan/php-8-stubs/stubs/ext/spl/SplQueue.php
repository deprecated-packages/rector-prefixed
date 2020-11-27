<?php

namespace _PhpScoper26e51eeacccf;

class SplQueue extends \SplDoublyLinkedList
{
    /**
     * @return void
     * @implementation-alias SplDoublyLinkedList::push
     */
    public function enqueue(mixed $value)
    {
    }
    /**
     * @return mixed
     * @implementation-alias SplDoublyLinkedList::shift
     */
    public function dequeue()
    {
    }
}
\class_alias('_PhpScoper26e51eeacccf\\SplQueue', 'SplQueue', \false);
