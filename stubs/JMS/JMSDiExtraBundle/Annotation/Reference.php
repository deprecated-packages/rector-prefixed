<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\JMS\DiExtraBundle\Annotation;

if (\class_exists('_PhpScoper006a73f0e455\\JMS\\DiExtraBundle\\Annotation\\Reference')) {
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
