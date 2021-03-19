<?php

declare (strict_types=1);
namespace RectorPrefix20210319\Symfony\Component\Validator\Constraints;

if (\class_exists('RectorPrefix20210319\\Symfony\\Component\\Validator\\Constraints\\NotBlank')) {
    return;
}
use InvalidArgumentException;
use RectorPrefix20210319\Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class NotBlank extends \RectorPrefix20210319\Symfony\Component\Validator\Constraint
{
    const IS_BLANK_ERROR = 'c1051bb4-d103-4f74-8988-acbcafc7fdc3';
    protected static $errorNames = [self::IS_BLANK_ERROR => 'IS_BLANK_ERROR'];
    public $message = 'This value should not be blank.';
    public $allowNull = \false;
    public $normalizer;
    public function __construct($options = null)
    {
        parent::__construct($options);
        if (null !== $this->normalizer && !\is_callable($this->normalizer)) {
            throw new \InvalidArgumentException(\sprintf('The "normalizer" option must be a valid callable ("%s" given).', \is_object($this->normalizer) ? \get_class($this->normalizer) : \gettype($this->normalizer)));
        }
    }
}
