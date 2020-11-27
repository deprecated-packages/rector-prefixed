<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoperbd5d0c5f7638\\Gedmo\\Mapping\\Annotation\\Loggable')) {
    return;
}
use _PhpScoperbd5d0c5f7638\Doctrine\Common\Annotations\Annotation;
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
