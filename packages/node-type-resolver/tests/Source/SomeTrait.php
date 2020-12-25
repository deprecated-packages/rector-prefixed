<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\Source;

trait SomeTrait
{
    public function getSomeClass() : \Rector\NodeTypeResolver\Tests\Source\SomeClass
    {
        return new \Rector\NodeTypeResolver\Tests\Source\SomeClass();
    }
}
