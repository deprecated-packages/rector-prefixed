<?php

namespace _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source;

use _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException;
use _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond;
use _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheThird;
class ExceptionsFactoryMethodNothingAnnotated
{
    public function isThis(int $code)
    {
        return new \_PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException();
    }
}
