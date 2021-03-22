<?php

declare (strict_types=1);
namespace RectorPrefix20210322\Gedmo\Mapping\Annotation;

if (\class_exists('Gedmo\\Mapping\\Annotation\\TreeRoot')) {
    return;
}
/**
 * @Annotation
 */
class TreeRoot
{
    /** @var string $identifierMethod */
    public $identifierMethod;
}
