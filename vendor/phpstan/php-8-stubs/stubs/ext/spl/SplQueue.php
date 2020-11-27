<?php

namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\SplQueue', 'SplQueue', \false);
