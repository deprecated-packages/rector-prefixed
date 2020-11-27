<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoper88fe6e0ad041\\Gedmo\\Mapping\\Annotation\\Loggable')) {
    return;
}
use _PhpScoper88fe6e0ad041\Doctrine\Common\Annotations\Annotation;
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
