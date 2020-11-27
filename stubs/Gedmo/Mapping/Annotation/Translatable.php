<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoperbd5d0c5f7638\\Gedmo\\Mapping\\Annotation\\Translatable')) {
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
