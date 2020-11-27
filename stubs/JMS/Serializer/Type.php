<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\JMS\Serializer\Annotation;

if (\class_exists('_PhpScoper26e51eeacccf\\JMS\\Serializer\\Annotation\\Type')) {
    return;
}
/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD","ANNOTATION"})
 */
class Type
{
    /**
     * @Required
     * @var string
     */
    public $name;
}
