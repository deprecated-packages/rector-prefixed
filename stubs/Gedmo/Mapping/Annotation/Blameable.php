<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoperabd03f0baf05\\Gedmo\\Mapping\\Annotation\\Blameable')) {
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
