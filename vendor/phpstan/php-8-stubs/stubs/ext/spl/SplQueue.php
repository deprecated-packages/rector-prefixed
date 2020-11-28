<?php

namespace _PhpScoperabd03f0baf05;

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
\class_alias('_PhpScoperabd03f0baf05\\SplQueue', 'SplQueue', \false);
