<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\JMS\Serializer\Annotation;

if (\class_exists('_PhpScoper88fe6e0ad041\\JMS\\Serializer\\Annotation\\Type')) {
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
