<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\PropertiesFromVariableIntoObject;

class Foo
{
    /**
     * @var string
     */
    public $foo = '';
    /**
     * @var int
     */
    public $lall = 0;
    public function create() : self
    {
        $self = new self();
        $data = 'foo';
        $property = 'lall';
        $self->{$property} = $data;
        $data = 'foo';
        $property = 'noop';
        $self->{$property} = $data;
        return $self;
    }
}
