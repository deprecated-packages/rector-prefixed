<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\JMS\DiExtraBundle\Annotation;

if (\class_exists('_PhpScoperabd03f0baf05\\JMS\\DiExtraBundle\\Annotation\\Reference')) {
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
