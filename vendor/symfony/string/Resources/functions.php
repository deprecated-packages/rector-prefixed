<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210303\Symfony\Component\String;

function u(?string $string = '') : \RectorPrefix20210303\Symfony\Component\String\UnicodeString
{
    return new \RectorPrefix20210303\Symfony\Component\String\UnicodeString($string ?? '');
}
function b(?string $string = '') : \RectorPrefix20210303\Symfony\Component\String\ByteString
{
    return new \RectorPrefix20210303\Symfony\Component\String\ByteString($string ?? '');
}
/**
 * @return UnicodeString|ByteString
 */
function s(?string $string = '') : \RectorPrefix20210303\Symfony\Component\String\AbstractString
{
    $string = $string ?? '';
    return \preg_match('//u', $string) ? new \RectorPrefix20210303\Symfony\Component\String\UnicodeString($string) : new \RectorPrefix20210303\Symfony\Component\String\ByteString($string);
}
