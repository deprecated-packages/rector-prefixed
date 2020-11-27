<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Symfony\Component\Validator\Constraints;

if (\class_exists('_PhpScopera143bcca66cb\\Symfony\\Component\\Validator\\Constraints\\Url')) {
    return;
}
use _PhpScopera143bcca66cb\Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Url extends \_PhpScopera143bcca66cb\Symfony\Component\Validator\Constraint
{
    public $message = 'This value is not a valid URL.';
    public $protocols = ['http', 'https'];
    public $relativeProtocol = \false;
    public $normalizer;
}
