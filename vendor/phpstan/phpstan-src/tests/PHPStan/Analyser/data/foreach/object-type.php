<?php

namespace _PhpScoperbd5d0c5f7638\ObjectType;

interface MyKey
{
}
interface MyValue
{
}
interface MyIterator extends \Iterator
{
    public function key() : \_PhpScoperbd5d0c5f7638\ObjectType\MyKey;
    public function current() : \_PhpScoperbd5d0c5f7638\ObjectType\MyValue;
}
interface MyIteratorAggregate extends \IteratorAggregate
{
    public function getIterator() : \_PhpScoperbd5d0c5f7638\ObjectType\MyIterator;
}
interface MyIteratorAggregateRecursive extends \IteratorAggregate
{
    public function getIterator() : \_PhpScoperbd5d0c5f7638\ObjectType\MyIteratorAggregateRecursive;
}
function test(\_PhpScoperbd5d0c5f7638\ObjectType\MyIterator $iterator, \_PhpScoperbd5d0c5f7638\ObjectType\MyIteratorAggregate $iteratorAggregate, \_PhpScoperbd5d0c5f7638\ObjectType\MyIteratorAggregateRecursive $iteratorAggregateRecursive)
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
