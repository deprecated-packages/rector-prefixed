<?php

namespace _PhpScopera143bcca66cb\DoctrineIntersectionTypeIsSupertypeOf;

use ArrayAccess;
use Countable;
use IteratorAggregate;
/**
 * @psalm-template TKey of array-key
 * @psalm-template T
 * @template-extends IteratorAggregate<TKey, T>
 * @template-extends ArrayAccess<TKey|null, T>
 */
interface Collection extends \Countable, \IteratorAggregate, \ArrayAccess
{
}
