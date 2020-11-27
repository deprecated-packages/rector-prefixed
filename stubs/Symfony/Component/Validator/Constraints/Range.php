<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Symfony\Component\Validator\Constraints;

if (\class_exists('_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Validator\\Constraints\\Range')) {
    return;
}
use _PhpScoperbd5d0c5f7638\Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Range extends \_PhpScoperbd5d0c5f7638\Symfony\Component\Validator\Constraint
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
