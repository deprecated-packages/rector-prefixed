<?php

declare (strict_types=1);
namespace RectorPrefix20210322\Gedmo\Mapping\Annotation;

if (\class_exists('Gedmo\\Mapping\\Annotation\\Loggable')) {
    return;
}
use RectorPrefix20210322\Doctrine\Common\Annotations\Annotation;
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
