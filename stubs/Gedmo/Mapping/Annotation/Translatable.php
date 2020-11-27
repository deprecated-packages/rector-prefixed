<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScopera143bcca66cb\\Gedmo\\Mapping\\Annotation\\Translatable')) {
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
