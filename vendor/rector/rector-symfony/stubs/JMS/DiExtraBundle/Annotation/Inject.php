<?php

declare (strict_types=1);
namespace RectorPrefix20210321\JMS\DiExtraBundle\Annotation;

if (\class_exists('JMS\\DiExtraBundle\\Annotation\\Inject')) {
    return;
}
/**
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class Inject extends \RectorPrefix20210321\JMS\DiExtraBundle\Annotation\Reference
{
}
