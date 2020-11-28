<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\JMS\Serializer\Annotation;

if (\class_exists('_PhpScoperabd03f0baf05\\JMS\\Serializer\\Annotation\\Type')) {
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
