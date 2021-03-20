<?php

declare (strict_types=1);
namespace Rector\Symfony\ValueObject;

final class ClassName
{
    /**
     * @var string
     */
    public const ROUTE_NAME_NAMESPACE = 'RectorPrefix20210320\\App\\ValueObject\\Routing';
    /**
     * @var string
     */
    public const ROUTE_CLASS_SHORT_NAME = 'RouteName';
    /**
     * @var string
     */
    public const ROUTE_CLASS_NAME = self::ROUTE_NAME_NAMESPACE . '\\' . self::ROUTE_CLASS_SHORT_NAME;
}
