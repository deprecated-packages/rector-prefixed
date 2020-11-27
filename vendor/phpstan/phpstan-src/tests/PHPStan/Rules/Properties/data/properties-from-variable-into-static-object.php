<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\PropertiesFromVariableIntoStaticObject;

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
