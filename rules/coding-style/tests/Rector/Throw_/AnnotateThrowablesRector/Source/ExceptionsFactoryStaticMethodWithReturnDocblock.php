<?php

namespace _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source;

use _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException;
use _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond;
use _PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheThird;
class ExceptionsFactoryStaticMethodWithReturnDocblock
{
    /**
     * This is the DocComment of createException().
     *
     * @param int $code
     *
     * @return TheException|TheExceptionTheSecond|TheExceptionTheThird|\RuntimeException
     */
    public static function createException(int $code)
    {
        switch ($code) {
            case 1:
                return new \_PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException();
            case 2:
                return new \_PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond();
            case 3:
                return new \_PhpScopere8e811afab72\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheThird();
            default:
                return new \RuntimeException();
        }
    }
}
