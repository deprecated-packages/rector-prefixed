<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\JMS\Serializer\Annotation;

if (\class_exists('_PhpScopera143bcca66cb\\JMS\\Serializer\\Annotation\\Type')) {
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
