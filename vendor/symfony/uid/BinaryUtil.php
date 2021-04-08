<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210408\Symfony\Component\Uid;

/**
 * @internal
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class BinaryUtil
{
    public const BASE10 = ['' => '0123456789', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    public const BASE58 = ['' => '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz', 1 => 0, 1, 2, 3, 4, 5, 6, 7, 8, 'A' => 9, 'B' => 10, 'C' => 11, 'D' => 12, 'E' => 13, 'F' => 14, 'G' => 15, 'H' => 16, 'J' => 17, 'K' => 18, 'L' => 19, 'M' => 20, 'N' => 21, 'P' => 22, 'Q' => 23, 'R' => 24, 'S' => 25, 'T' => 26, 'U' => 27, 'V' => 28, 'W' => 29, 'X' => 30, 'Y' => 31, 'Z' => 32, 'a' => 33, 'b' => 34, 'c' => 35, 'd' => 36, 'e' => 37, 'f' => 38, 'g' => 39, 'h' => 40, 'i' => 41, 'j' => 42, 'k' => 43, 'm' => 44, 'n' => 45, 'o' => 46, 'p' => 47, 'q' => 48, 'r' => 49, 's' => 50, 't' => 51, 'u' => 52, 'v' => 53, 'w' => 54, 'x' => 55, 'y' => 56, 'z' => 57];
    // https://tools.ietf.org/html/rfc4122#section-4.1.4
    // 0x01b21dd213814000 is the number of 100-ns intervals between the
    // UUID epoch 1582-10-15 00:00:00 and the Unix epoch 1970-01-01 00:00:00.
    private const TIME_OFFSET_INT = 0x1b21dd213814000;
    private const TIME_OFFSET_BIN = "\1�\35�\23�@\0";
    private const TIME_OFFSET_COM1 = "�M�-�~��";
    private const TIME_OFFSET_COM2 = "�M�-�~�\0";
    public static function toBase(string $bytes, array $map) : string
    {
        $base = \strlen($alphabet = $map['']);
        $bytes = \array_values(\unpack(\PHP_INT_SIZE >= 8 ? 'n*' : 'C*', $bytes));
        $digits = '';
        while ($count = \count($bytes)) {
            $quotient = [];
            $remainder = 0;
            for ($i = 0; $i !== $count; ++$i) {
                $carry = $bytes[$i] + ($remainder << (\PHP_INT_SIZE >= 8 ? 16 : 8));
                $digit = \intdiv($carry, $base);
                $remainder = $carry % $base;
                if ($digit || $quotient) {
                    $quotient[] = $digit;
                }
            }
            $digits = $alphabet[$remainder] . $digits;
            $bytes = $quotient;
        }
        return $digits;
    }
    public static function fromBase(string $digits, array $map) : string
    {
        $base = \strlen($map['']);
        $count = \strlen($digits);
        $bytes = [];
        while ($count) {
            $quotient = [];
            $remainder = 0;
            for ($i = 0; $i !== $count; ++$i) {
                $carry = ($bytes ? $digits[$i] : $map[$digits[$i]]) + $remainder * $base;
                if (\PHP_INT_SIZE >= 8) {
                    $digit = $carry >> 16;
                    $remainder = $carry & 0xffff;
                } else {
                    $digit = $carry >> 8;
                    $remainder = $carry & 0xff;
                }
                if ($digit || $quotient) {
                    $quotient[] = $digit;
                }
            }
            $bytes[] = $remainder;
            $count = \count($digits = $quotient);
        }
        return \pack(\PHP_INT_SIZE >= 8 ? 'n*' : 'C*', ...\array_reverse($bytes));
    }
    public static function add(string $a, string $b) : string
    {
        $carry = 0;
        for ($i = 7; 0 <= $i; --$i) {
            $carry += \ord($a[$i]) + \ord($b[$i]);
            $a[$i] = \chr($carry & 0xff);
            $carry >>= 8;
        }
        return $a;
    }
    /**
     * @param string $time Count of 100-nanosecond intervals since the UUID epoch 1582-10-15 00:00:00 in hexadecimal
     */
    public static function timeToFloat(string $time) : float
    {
        if (\PHP_INT_SIZE >= 8) {
            $time = \hexdec($time) - self::TIME_OFFSET_INT;
        } else {
            $time = \str_pad(\hex2bin($time), 8, "\0", \STR_PAD_LEFT);
            if (self::TIME_OFFSET_BIN <= $time) {
                $time = self::add($time, self::TIME_OFFSET_COM2);
                $time[0] = $time[0] & "";
                $time = self::toBase($time, self::BASE10);
            } else {
                $time = self::add($time, self::TIME_OFFSET_COM1);
                $time = '-' . self::toBase($time ^ "��������", self::BASE10);
            }
        }
        return $time / 10000000;
    }
}
