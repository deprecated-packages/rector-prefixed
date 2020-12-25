<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfce0de0de1ce\Symfony\Component\String;

function u(?string $string = '') : \_PhpScoperfce0de0de1ce\Symfony\Component\String\UnicodeString
{
    return new \_PhpScoperfce0de0de1ce\Symfony\Component\String\UnicodeString($string ?? '');
}
function b(?string $string = '') : \_PhpScoperfce0de0de1ce\Symfony\Component\String\ByteString
{
    return new \_PhpScoperfce0de0de1ce\Symfony\Component\String\ByteString($string ?? '');
}
/**
 * @return UnicodeString|ByteString
 */
function s(?string $string = '') : \_PhpScoperfce0de0de1ce\Symfony\Component\String\AbstractString
{
    $string = $string ?? '';
    return \preg_match('//u', $string) ? new \_PhpScoperfce0de0de1ce\Symfony\Component\String\UnicodeString($string) : new \_PhpScoperfce0de0de1ce\Symfony\Component\String\ByteString($string);
}
