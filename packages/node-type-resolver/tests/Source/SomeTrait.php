<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\Source;

trait SomeTrait
{
    public function getSomeClass() : \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\Source\SomeClass
    {
        return new \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\Source\SomeClass();
    }
}
