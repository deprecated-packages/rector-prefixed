<?php

declare(strict_types=1);

namespace Rector\CodingStyle\ValueObject;

/**
 * @enum
 */
final class PreferenceSelfThis
{
    /**
     * @var string[]
     */
    const ALLOWED_VALUES = [self::PREFER_THIS, self::PREFER_SELF];

    /**
     * @api
     * @var string
     */
    const PREFER_THIS = 'prefer_this';

    /**
     * @api
     * @var string
     */
    const PREFER_SELF = 'prefer_self';
}
