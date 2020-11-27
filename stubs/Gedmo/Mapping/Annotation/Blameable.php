<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoper88fe6e0ad041\\Gedmo\\Mapping\\Annotation\\Blameable')) {
    return;
}
/**
 * @Annotation
 */
class Blameable
{
    /**
     * @var string
     */
    public $on = 'update';
    /**
     * @var mixed
     */
    public $field;
    /**
     * @var mixed
     */
    public $value;
}
