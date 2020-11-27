<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoperbd5d0c5f7638\\Gedmo\\Mapping\\Annotation\\Blameable')) {
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
