<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210316\Symfony\Polyfill\Tests\Intl\Normalizer;

use Normalizer as in;
use RectorPrefix20210316\PHPUnit\Framework\TestCase;
use RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer as pn;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @covers \Symfony\Polyfill\Intl\Normalizer\Normalizer::<!public>
 * @requires extension intl
 */
class NormalizerTest extends \RectorPrefix20210316\PHPUnit\Framework\TestCase
{
    public function testConstants()
    {
        $rpn = new \ReflectionClass('RectorPrefix20210316\\Symfony\\Polyfill\\Intl\\Normalizer\\Normalizer');
        $rin = new \ReflectionClass('Normalizer');
        $rpn = $rpn->getConstants();
        $rin = $rin->getConstants();
        unset($rin['NONE'], $rin['FORM_KC_CF'], $rin['NFKC_CF']);
        \ksort($rpn);
        \ksort($rin);
        $this->assertSame($rin, $rpn);
    }
    /**
     * @covers \Symfony\Polyfill\Intl\Normalizer\Normalizer::isNormalized
     */
    public function testIsNormalized()
    {
        $c = 'déjà';
        $d = \Normalizer::normalize($c, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD);
        $this->assertTrue(\normalizer_is_normalized(''));
        $this->assertTrue(\normalizer_is_normalized('abc'));
        $this->assertTrue(\normalizer_is_normalized($c));
        $this->assertTrue(\normalizer_is_normalized($c, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFC));
        $this->assertFalse(\normalizer_is_normalized($c, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD));
        $this->assertFalse(\normalizer_is_normalized($d, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFC));
        $this->assertFalse(\normalizer_is_normalized("�"));
        $this->assertTrue(\RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::isNormalized($d, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD));
        $this->assertFalse(\RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::isNormalized('', 42));
    }
    /**
     * @covers \Symfony\Polyfill\Intl\Normalizer\Normalizer::normalize
     */
    public function testNormalize()
    {
        $c = \Normalizer::normalize('déjà', \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFC) . \Normalizer::normalize('훈쇼™', \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD);
        if (\PHP_VERSION_ID < 70300) {
            $this->assertSame($c, \normalizer_normalize($c, \Normalizer::NONE));
        }
        $c = 'déjà 훈쇼™';
        $d = \Normalizer::normalize($c, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD);
        $kc = \Normalizer::normalize($c, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKC);
        $kd = \Normalizer::normalize($c, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKD);
        $this->assertSame('', \normalizer_normalize(''));
        $this->assertSame($c, \normalizer_normalize($d));
        $this->assertSame($c, \normalizer_normalize($d, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFC));
        $this->assertSame($d, \normalizer_normalize($c, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD));
        $this->assertSame($kc, \normalizer_normalize($d, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKC));
        $this->assertSame($kd, \normalizer_normalize($c, \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKD));
        $this->assertFalse(\normalizer_normalize("�"));
        $this->assertSame("̃Ò՛", \normalizer_normalize("̃Ò՛"));
        $this->assertSame("ྲཱྀྀ", \normalizer_normalize("ྲཱྀྀ", \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD));
    }
    /**
     * @covers \Symfony\Polyfill\Intl\Normalizer\Normalizer::normalize
     */
    public function testNormalizeWithInvalidForm()
    {
        if (80000 <= \PHP_VERSION_ID) {
            $this->expectException(\ValueError::class);
            $this->expectExceptionMessage('normalizer_normalize(): Argument #2 ($form) must be a a valid normalization form');
        }
        $this->assertFalse(\normalizer_normalize('foo', -1));
    }
    /**
     * @covers \Symfony\Polyfill\Intl\Normalizer\Normalizer::normalize
     */
    public function testNormalizeConformance()
    {
        $t = \file(__DIR__ . '/NormalizationTest.txt');
        $c = [];
        foreach ($t as $s) {
            $t = \explode('#', $s);
            $t = \explode(';', $t[0]);
            if (6 === \count($t)) {
                foreach ($t as $k => $s) {
                    $t = \explode(' ', $s);
                    $t = \array_map('hexdec', $t);
                    $t = \array_map(__CLASS__ . '::chr', $t);
                    $c[$k] = \implode('', $t);
                }
                $this->assertSame($c[1], \normalizer_normalize($c[0], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFC));
                $this->assertSame($c[1], \normalizer_normalize($c[1], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFC));
                $this->assertSame($c[1], \normalizer_normalize($c[2], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFC));
                $this->assertSame($c[3], \normalizer_normalize($c[3], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFC));
                $this->assertSame($c[3], \normalizer_normalize($c[4], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFC));
                $this->assertSame($c[2], \normalizer_normalize($c[0], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD));
                $this->assertSame($c[2], \normalizer_normalize($c[1], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD));
                $this->assertSame($c[2], \normalizer_normalize($c[2], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD));
                $this->assertSame($c[4], \normalizer_normalize($c[3], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD));
                $this->assertSame($c[4], \normalizer_normalize($c[4], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFD));
                $this->assertSame($c[3], \normalizer_normalize($c[0], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKC));
                $this->assertSame($c[3], \normalizer_normalize($c[1], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKC));
                $this->assertSame($c[3], \normalizer_normalize($c[2], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKC));
                $this->assertSame($c[3], \normalizer_normalize($c[3], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKC));
                $this->assertSame($c[3], \normalizer_normalize($c[4], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKC));
                $this->assertSame($c[4], \normalizer_normalize($c[0], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKD));
                $this->assertSame($c[4], \normalizer_normalize($c[1], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKD));
                $this->assertSame($c[4], \normalizer_normalize($c[2], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKD));
                $this->assertSame($c[4], \normalizer_normalize($c[3], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKD));
                $this->assertSame($c[4], \normalizer_normalize($c[4], \RectorPrefix20210316\Symfony\Polyfill\Intl\Normalizer\Normalizer::NFKD));
            }
        }
    }
    private static function chr($c)
    {
        if (0x80 > ($c %= 0x200000)) {
            return \chr($c);
        }
        if (0x800 > $c) {
            return \chr(0xc0 | $c >> 6) . \chr(0x80 | $c & 0x3f);
        }
        if (0x10000 > $c) {
            return \chr(0xe0 | $c >> 12) . \chr(0x80 | $c >> 6 & 0x3f) . \chr(0x80 | $c & 0x3f);
        }
        return \chr(0xf0 | $c >> 18) . \chr(0x80 | $c >> 12 & 0x3f) . \chr(0x80 | $c >> 6 & 0x3f) . \chr(0x80 | $c & 0x3f);
    }
}
