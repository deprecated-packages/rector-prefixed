<?php

namespace RectorPrefix20210316;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use RectorPrefix20210316\Symfony\Polyfill\Intl\MessageFormatter\MessageFormatter as p;
if (!\function_exists('msgfmt_format_message')) {
    function msgfmt_format_message($locale, $pattern, array $args)
    {
        return \RectorPrefix20210316\Symfony\Polyfill\Intl\MessageFormatter\MessageFormatter::formatMessage($locale, $pattern, $args);
    }
}
