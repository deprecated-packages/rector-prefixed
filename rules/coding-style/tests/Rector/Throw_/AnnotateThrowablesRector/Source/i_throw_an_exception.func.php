<?php

namespace _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source;

use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond;
/**
 * @param null|string $switch
 * @throws TheException
 * @throws TheExceptionTheSecond
 * @throws \Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheThird
 */
function i_throw_an_exception(?string $switch = null) : bool
{
    switch ($switch) {
        case 'two':
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond("I'm a function that throws an exception.");
        case 'third':
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheThird("I'm a function that throws an exception.");
        default:
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException("I'm a function that throws an exception.");
    }
}
