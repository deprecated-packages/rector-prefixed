<?php

declare(strict_types=1);

namespace Symplify\Skipper\ValueObject;

final class Option
{
    /**
     * @api
     * @var string
     */
    public const SKIP = 'skip';

    /**
     * @api
     * @var string
     */
    public const ONLY = 'only';
}
