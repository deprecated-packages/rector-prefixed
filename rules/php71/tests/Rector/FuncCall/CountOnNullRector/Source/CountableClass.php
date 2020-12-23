<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php71\Tests\Rector\FuncCall\CountOnNullRector\Source;

use Countable;
final class CountableClass implements \Countable
{
    public function count()
    {
        return 0;
    }
}
