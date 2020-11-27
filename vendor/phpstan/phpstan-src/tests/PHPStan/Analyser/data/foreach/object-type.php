<?php

namespace _PhpScoper88fe6e0ad041\ObjectType;

interface MyKey
{
}
interface MyValue
{
}
interface MyIterator extends \Iterator
{
    public function key() : \_PhpScoper88fe6e0ad041\ObjectType\MyKey;
    public function current() : \_PhpScoper88fe6e0ad041\ObjectType\MyValue;
}
interface MyIteratorAggregate extends \IteratorAggregate
{
    public function getIterator() : \_PhpScoper88fe6e0ad041\ObjectType\MyIterator;
}
interface MyIteratorAggregateRecursive extends \IteratorAggregate
{
    public function getIterator() : \_PhpScoper88fe6e0ad041\ObjectType\MyIteratorAggregateRecursive;
}
function test(\_PhpScoper88fe6e0ad041\ObjectType\MyIterator $iterator, \_PhpScoper88fe6e0ad041\ObjectType\MyIteratorAggregate $iteratorAggregate, \_PhpScoper88fe6e0ad041\ObjectType\MyIteratorAggregateRecursive $iteratorAggregateRecursive)
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
