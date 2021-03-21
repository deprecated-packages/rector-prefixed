<?php

declare (strict_types=1);
namespace RectorPrefix20210321\JMS\DiExtraBundle\Annotation;

if (\class_exists('JMS\\DiExtraBundle\\Annotation\\Reference')) {
    return;
}
abstract class Reference
{
    /**
     * @var string
     */
    public $value;
    /**
     * @var bool
     */
    public $required;
    /**
     * @var bool
     */
    public $strict = \true;
}
