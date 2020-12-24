<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php71\Tests\Rector\FuncCall\CountOnNullRector\Source;

use Countable;
final class CountableClass implements \Countable
{
    public function count()
    {
        return 0;
    }
}
