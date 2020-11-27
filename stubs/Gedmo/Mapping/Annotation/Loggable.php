<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoper006a73f0e455\\Gedmo\\Mapping\\Annotation\\Loggable')) {
    return;
}
use _PhpScoper006a73f0e455\Doctrine\Common\Annotations\Annotation;
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
