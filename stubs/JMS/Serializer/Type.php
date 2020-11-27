<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\JMS\Serializer\Annotation;

if (\class_exists('_PhpScoperbd5d0c5f7638\\JMS\\Serializer\\Annotation\\Type')) {
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
