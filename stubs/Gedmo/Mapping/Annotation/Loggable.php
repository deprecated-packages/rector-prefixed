<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoperabd03f0baf05\\Gedmo\\Mapping\\Annotation\\Loggable')) {
    return;
}
use _PhpScoperabd03f0baf05\Doctrine\Common\Annotations\Annotation;
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
