<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoper006a73f0e455\\Gedmo\\Mapping\\Annotation\\Blameable')) {
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
