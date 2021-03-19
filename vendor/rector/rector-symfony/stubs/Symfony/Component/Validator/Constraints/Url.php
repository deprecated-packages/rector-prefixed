<?php

declare (strict_types=1);
namespace RectorPrefix20210319\Symfony\Component\Validator\Constraints;

if (\class_exists('RectorPrefix20210319\\Symfony\\Component\\Validator\\Constraints\\Url')) {
    return;
}
use RectorPrefix20210319\Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Url extends \RectorPrefix20210319\Symfony\Component\Validator\Constraint
{
    public $message = 'This value is not a valid URL.';
    public $protocols = ['http', 'https'];
    public $relativeProtocol = \false;
    public $normalizer;
}
