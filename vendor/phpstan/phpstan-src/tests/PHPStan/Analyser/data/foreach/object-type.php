<?php

namespace _PhpScoperabd03f0baf05\ObjectType;

interface MyKey
{
}
interface MyValue
{
}
interface MyIterator extends \Iterator
{
    public function key() : \_PhpScoperabd03f0baf05\ObjectType\MyKey;
    public function current() : \_PhpScoperabd03f0baf05\ObjectType\MyValue;
}
interface MyIteratorAggregate extends \IteratorAggregate
{
    public function getIterator() : \_PhpScoperabd03f0baf05\ObjectType\MyIterator;
}
interface MyIteratorAggregateRecursive extends \IteratorAggregate
{
    public function getIterator() : \_PhpScoperabd03f0baf05\ObjectType\MyIteratorAggregateRecursive;
}
function test(\_PhpScoperabd03f0baf05\ObjectType\MyIterator $iterator, \_PhpScoperabd03f0baf05\ObjectType\MyIteratorAggregate $iteratorAggregate, \_PhpScoperabd03f0baf05\ObjectType\MyIteratorAggregateRecursive $iteratorAggregateRecursive)
{
    foreach ($iterator as $keyFromIterator => $valueFromIterator) {
        'insideFirstForeach';
    }
    foreach ($iteratorAggregate as $keyFromAggregate => $valueFromAggregate) {
        'insideSecondForeach';
    }
    foreach ($iteratorAggregateRecursive as $keyFromRecursiveAggregate => $valueFromRecursiveAggregate) {
        'insideThirdForeach';
    }
}
