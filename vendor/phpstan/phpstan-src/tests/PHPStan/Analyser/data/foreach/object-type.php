<?php

namespace _PhpScoper26e51eeacccf\ObjectType;

interface MyKey
{
}
interface MyValue
{
}
interface MyIterator extends \Iterator
{
    public function key() : \_PhpScoper26e51eeacccf\ObjectType\MyKey;
    public function current() : \_PhpScoper26e51eeacccf\ObjectType\MyValue;
}
interface MyIteratorAggregate extends \IteratorAggregate
{
    public function getIterator() : \_PhpScoper26e51eeacccf\ObjectType\MyIterator;
}
interface MyIteratorAggregateRecursive extends \IteratorAggregate
{
    public function getIterator() : \_PhpScoper26e51eeacccf\ObjectType\MyIteratorAggregateRecursive;
}
function test(\_PhpScoper26e51eeacccf\ObjectType\MyIterator $iterator, \_PhpScoper26e51eeacccf\ObjectType\MyIteratorAggregate $iteratorAggregate, \_PhpScoper26e51eeacccf\ObjectType\MyIteratorAggregateRecursive $iteratorAggregateRecursive)
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
