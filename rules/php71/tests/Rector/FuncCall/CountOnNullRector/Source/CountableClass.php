<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php71\Tests\Rector\FuncCall\CountOnNullRector\Source;

use Countable;
final class CountableClass implements \Countable
{
    public function count()
    {
        return 0;
    }
}
