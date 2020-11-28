<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Symfony\Component\Validator\Constraints;

if (\class_exists('_PhpScoperabd03f0baf05\\Symfony\\Component\\Validator\\Constraints\\Url')) {
    return;
}
use _PhpScoperabd03f0baf05\Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Url extends \_PhpScoperabd03f0baf05\Symfony\Component\Validator\Constraint
{
    public $message = 'This value is not a valid URL.';
    public $protocols = ['http', 'https'];
    public $relativeProtocol = \false;
    public $normalizer;
}
