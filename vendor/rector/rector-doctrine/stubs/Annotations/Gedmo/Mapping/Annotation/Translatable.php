<?php

declare (strict_types=1);
namespace RectorPrefix20210322\Gedmo\Mapping\Annotation;

if (\class_exists('Gedmo\\Mapping\\Annotation\\Translatable')) {
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
