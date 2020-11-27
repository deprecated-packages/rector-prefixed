<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoper26e51eeacccf\\Gedmo\\Mapping\\Annotation\\Translatable')) {
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
