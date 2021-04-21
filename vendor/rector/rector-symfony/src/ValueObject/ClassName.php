<?php

declare(strict_types=1);

namespace Rector\Symfony\ValueObject;

final class ClassName
{
    /**
     * @var string
     */
    const ROUTE_NAME_NAMESPACE = 'App\ValueObject\Routing';

    /**
     * @var string
     */
    const ROUTE_CLASS_SHORT_NAME = 'RouteName';

    /**
     * @var string
     */
    const ROUTE_CLASS_NAME = self::ROUTE_NAME_NAMESPACE . '\\' . self::ROUTE_CLASS_SHORT_NAME;
}
