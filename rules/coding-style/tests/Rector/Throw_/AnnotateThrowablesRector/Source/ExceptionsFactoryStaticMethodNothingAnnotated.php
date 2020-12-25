<?php

namespace Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source;

use Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException;
use Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond;
use Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheThird;
class ExceptionsFactoryStaticMethodNothingAnnotated
{
    public static function createException(int $code)
    {
        switch ($code) {
            case 1:
                return new \Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException();
            case 2:
                return new \Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond();
            case 3:
                return new \Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheThird();
            default:
                return new \RuntimeException();
        }
    }
}
