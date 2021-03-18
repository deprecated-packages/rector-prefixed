<?php

declare (strict_types=1);
namespace RectorPrefix20210318\Symfony\Component\Validator\Constraints;

if (\class_exists('RectorPrefix20210318\\Symfony\\Component\\Validator\\Constraints\\Range')) {
    return;
}
use RectorPrefix20210318\Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Range extends \RectorPrefix20210318\Symfony\Component\Validator\Constraint
{
    public $notInRangeMessage = 'This value should be between {{ min }} and {{ max }}.';
    public $minMessage = 'This value should be {{ limit }} or more.';
    public $maxMessage = 'This value should be {{ limit }} or less.';
    public $invalidMessage = 'This value should be a valid number.';
    public $min;
    public $minPropertyPath;
    public $max;
    public $maxPropertyPath;
}
