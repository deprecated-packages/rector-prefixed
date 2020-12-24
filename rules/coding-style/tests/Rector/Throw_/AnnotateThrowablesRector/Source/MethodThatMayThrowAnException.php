<?php

namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source;

use _PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond;
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
                throw new \_PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException('');
            case 2:
                throw new \_PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond('');
            default:
                return $code;
        }
    }
}
