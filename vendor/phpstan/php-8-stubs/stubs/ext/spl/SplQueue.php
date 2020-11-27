<?php

namespace _PhpScopera143bcca66cb;

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
\class_alias('_PhpScopera143bcca66cb\\SplQueue', 'SplQueue', \false);
