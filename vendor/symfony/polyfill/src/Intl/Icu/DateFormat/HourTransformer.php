<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\DateFormat;

/**
 * Base class for hour transformers.
 *
 * @author Eriksen Costa <eriksen.costa@infranology.com.br>
 *
 * @internal
 */
abstract class HourTransformer extends \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\DateFormat\Transformer
{
    /**
     * Returns a normalized hour value suitable for the hour transformer type.
     *
     * @param int    $hour   The hour value
     * @param string $marker An optional AM/PM marker
     *
     * @return int The normalized hour value
     */
    public abstract function normalizeHour(int $hour, string $marker = null) : int;
}
