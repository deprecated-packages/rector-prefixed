<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\SplQueue', 'SplQueue', \false);
