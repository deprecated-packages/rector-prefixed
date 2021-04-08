<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210408\Nette\Neon;

/**
 * Simple parser & generator for Nette Object Notation.
 * @see https://ne-on.org
 */
final class Neon
{
    public const BLOCK = \RectorPrefix20210408\Nette\Neon\Encoder::BLOCK;
    public const CHAIN = '!!chain';
    /**
     * Returns value converted to NEON. The flag can be Neon::BLOCK, which will create multiline output.
     */
    public static function encode($value, int $flags = 0) : string
    {
        $encoder = new \RectorPrefix20210408\Nette\Neon\Encoder();
        return $encoder->encode($value, $flags);
    }
    /**
     * Converts given NEON to PHP value.
     * Returns scalars, arrays, DateTimeImmutable and Entity objects.
     * @return mixed
     */
    public static function decode(string $input)
    {
        $decoder = new \RectorPrefix20210408\Nette\Neon\Decoder();
        return $decoder->decode($input);
    }
}
