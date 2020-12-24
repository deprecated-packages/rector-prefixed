<?php

namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source;

use _PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond;
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
                throw new \_PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException('');
            case 2:
                throw new \_PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond('');
            default:
                return $code;
        }
    }
}
