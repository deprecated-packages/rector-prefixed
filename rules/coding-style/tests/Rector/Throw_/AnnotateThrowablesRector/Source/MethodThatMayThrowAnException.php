<?php

namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source;

use _PhpScoper0a2ac50786fa\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond;
class MethodThatMayThrowAnException
{
    /**
     * @param int $code
     *
     * @return int
     * @throws TheException
     * @throws \Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond
     */
    public function mayThrowAnException(int $code) : int
    {
        switch ($code) {
            case 1:
                throw new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException('');
            case 2:
                throw new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond('');
            default:
                return $code;
        }
    }
}
