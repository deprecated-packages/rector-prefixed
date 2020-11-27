<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoper26e51eeacccf\\Gedmo\\Mapping\\Annotation\\Loggable')) {
    return;
}
use _PhpScoper26e51eeacccf\Doctrine\Common\Annotations\Annotation;
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
