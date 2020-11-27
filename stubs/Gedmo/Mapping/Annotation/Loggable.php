<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScopera143bcca66cb\\Gedmo\\Mapping\\Annotation\\Loggable')) {
    return;
}
use _PhpScopera143bcca66cb\Doctrine\Common\Annotations\Annotation;
/**
 * @Annotation
 */
class Loggable
{
    /**
     * @var string
     */
    public $logEntryClass;
}
