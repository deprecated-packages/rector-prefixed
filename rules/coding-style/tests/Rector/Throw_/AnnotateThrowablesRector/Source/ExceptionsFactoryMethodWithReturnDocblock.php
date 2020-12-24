<?php

namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source;

use _PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheThird;
class ExceptionsFactoryMethodWithReturnDocblock
{
    /**
     * This is the DocComment of createException().
     *
     * @param int $code
     *
     * @return TheException|TheExceptionTheSecond|TheExceptionTheThird|\RuntimeException
     */
    public function createException(int $code)
    {
        switch ($code) {
            case 1:
                return new \_PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheException();
            case 2:
                return new \_PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheSecond();
            case 3:
                return new \_PhpScoperb75b35f52b74\Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\Source\Exceptions\TheExceptionTheThird();
            default:
                return new \RuntimeException();
        }
    }
}
