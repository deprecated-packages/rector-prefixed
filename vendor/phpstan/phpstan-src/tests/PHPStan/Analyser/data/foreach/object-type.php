<?php

namespace _PhpScoper006a73f0e455\ObjectType;

interface MyKey
{
}
interface MyValue
{
}
interface MyIterator extends \Iterator
{
    public function key() : \_PhpScoper006a73f0e455\ObjectType\MyKey;
    public function current() : \_PhpScoper006a73f0e455\ObjectType\MyValue;
}
interface MyIteratorAggregate extends \IteratorAggregate
{
    public function getIterator() : \_PhpScoper006a73f0e455\ObjectType\MyIterator;
}
interface MyIteratorAggregateRecursive extends \IteratorAggregate
{
    public function getIterator() : \_PhpScoper006a73f0e455\ObjectType\MyIteratorAggregateRecursive;
}
function test(\_PhpScoper006a73f0e455\ObjectType\MyIterator $iterator, \_PhpScoper006a73f0e455\ObjectType\MyIteratorAggregate $iteratorAggregate, \_PhpScoper006a73f0e455\ObjectType\MyIteratorAggregateRecursive $iteratorAggregateRecursive)
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
