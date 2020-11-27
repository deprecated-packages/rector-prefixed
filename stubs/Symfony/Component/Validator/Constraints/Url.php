<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Symfony\Component\Validator\Constraints;

if (\class_exists('_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Validator\\Constraints\\Url')) {
    return;
}
use _PhpScoperbd5d0c5f7638\Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Url extends \_PhpScoperbd5d0c5f7638\Symfony\Component\Validator\Constraint
{
    public $message = 'This value is not a valid URL.';
    public $protocols = ['http', 'https'];
    public $relativeProtocol = \false;
    public $normalizer;
}
