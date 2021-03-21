<?php

declare (strict_types=1);
namespace RectorPrefix20210321\Symfony\Component\Validator\Constraints;

if (\class_exists('Symfony\\Component\\Validator\\Constraints\\Choice')) {
    return;
}
use RectorPrefix20210321\Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Choice extends \RectorPrefix20210321\Symfony\Component\Validator\Constraint
{
    const NO_SUCH_CHOICE_ERROR = '8e179f1b-97aa-4560-a02f-2a8b42e49df7';
    const TOO_FEW_ERROR = '11edd7eb-5872-4b6e-9f12-89923999fd0e';
    const TOO_MANY_ERROR = '9bd98e49-211c-433f-8630-fd1c2d0f08c3';
    protected static $errorNames = [self::NO_SUCH_CHOICE_ERROR => 'NO_SUCH_CHOICE_ERROR', self::TOO_FEW_ERROR => 'TOO_FEW_ERROR', self::TOO_MANY_ERROR => 'TOO_MANY_ERROR'];
    public $choices;
    public $callback;
    public $multiple = \false;
    public $strict = \true;
    public $min;
    public $max;
    public $message = 'The value you selected is not a valid choice.';
    public $multipleMessage = 'One or more of the given values is invalid.';
    public $minMessage = 'You must select at least {{ limit }} choice.|You must select at least {{ limit }} choices.';
    public $maxMessage = 'You must select at most {{ limit }} choice.|You must select at most {{ limit }} choices.';
    /**
     * {@inheritdoc}
     */
    public function getDefaultOption()
    {
        return 'choices';
    }
}
