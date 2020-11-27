<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Symfony\Component\Validator\Constraints;

if (\class_exists('_PhpScoper88fe6e0ad041\\Symfony\\Component\\Validator\\Constraints\\Url')) {
    return;
}
use _PhpScoper88fe6e0ad041\Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Url extends \_PhpScoper88fe6e0ad041\Symfony\Component\Validator\Constraint
{
    public $message = 'This value is not a valid URL.';
    public $protocols = ['http', 'https'];
    public $relativeProtocol = \false;
    public $normalizer;
}
