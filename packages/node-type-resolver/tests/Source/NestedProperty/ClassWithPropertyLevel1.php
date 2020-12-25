<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\Source\NestedProperty;

final class ClassWithPropertyLevel1 extends \Rector\NodeTypeResolver\Tests\Source\NestedProperty\ParentClass
{
    /**
     * @var ClassWithPropertyLevel2[]
     */
    public $level2s;
}
