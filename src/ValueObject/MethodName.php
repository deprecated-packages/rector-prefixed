<?php

declare(strict_types=1);

namespace Rector\Core\ValueObject;

final class MethodName
{
    /**
     * @var string
     */
    const CONSTRUCT = '__construct';

    /**
     * @var string
     */
    const DESCTRUCT = '__destruct';

    /**
     * @var string
     */
    const CLONE = '__clone';

    /**
     * Mostly used in unit tests
     * @var string
     */
    const SET_UP = 'setUp';

    /**
     * Mostly used in unit tests
     * @var string
     */
    const TEAR_DOWN = 'tearDown';

    /**
     * @var string
     */
    const SET_STATE = '__set_state';
}
