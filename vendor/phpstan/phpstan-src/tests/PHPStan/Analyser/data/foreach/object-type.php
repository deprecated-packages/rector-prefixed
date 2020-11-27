<?php

namespace _PhpScopera143bcca66cb\ObjectType;

interface MyKey
{
}
interface MyValue
{
}
interface MyIterator extends \Iterator
{
    public function key() : \_PhpScopera143bcca66cb\ObjectType\MyKey;
    public function current() : \_PhpScopera143bcca66cb\ObjectType\MyValue;
}
interface MyIteratorAggregate extends \IteratorAggregate
{
    public function getIterator() : \_PhpScopera143bcca66cb\ObjectType\MyIterator;
}
interface MyIteratorAggregateRecursive extends \IteratorAggregate
{
    public function getIterator() : \_PhpScopera143bcca66cb\ObjectType\MyIteratorAggregateRecursive;
}
function test(\_PhpScopera143bcca66cb\ObjectType\MyIterator $iterator, \_PhpScopera143bcca66cb\ObjectType\MyIteratorAggregate $iteratorAggregate, \_PhpScopera143bcca66cb\ObjectType\MyIteratorAggregateRecursive $iteratorAggregateRecursive)
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
