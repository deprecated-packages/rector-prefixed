<?php

namespace RectorPrefix20210504\App;

use RectorPrefix20210504\Symfony\Component\Validator\Constraint;
use RectorPrefix20210504\Symfony\Component\Validator\ConstraintValidator;
class Foo extends \RectorPrefix20210504\Symfony\Component\Validator\ConstraintValidator
{
    /**
     * @param mixed $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     *
     * @return void
     */
    public function validate($value, \RectorPrefix20210504\Symfony\Component\Validator\Constraint $constraint) : void
    {
        $this->context->buildViolation('foo');
    }
}
