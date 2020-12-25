<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source;

new class extends \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ParentClass implements \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterface
{
    use AnotherTrait;
};
