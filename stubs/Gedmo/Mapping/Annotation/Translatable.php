<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoper88fe6e0ad041\\Gedmo\\Mapping\\Annotation\\Translatable')) {
    return;
}
/**
 * @Annotation
 */
class Translatable
{
    /** @var boolean */
    public $fallback;
}
