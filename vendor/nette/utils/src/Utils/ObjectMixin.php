<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210423\Nette\Utils;

use RectorPrefix20210423\Nette;
/**
 * Nette\Object behaviour mixin.
 * @deprecated
 */
final class ObjectMixin
{
    use Nette\StaticClass;
    /** @deprecated  use ObjectHelpers::getSuggestion() */
    public static function getSuggestion(array $possibilities, string $value) : ?string
    {
        \trigger_error(__METHOD__ . '() has been renamed to Nette\\Utils\\ObjectHelpers::getSuggestion()', \E_USER_DEPRECATED);
        return \RectorPrefix20210423\Nette\Utils\ObjectHelpers::getSuggestion($possibilities, $value);
    }
    /**
     * @return void
     */
    public static function setExtensionMethod()
    {
        \trigger_error('Class Nette\\Utils\\ObjectMixin is deprecated', \E_USER_DEPRECATED);
    }
    /**
     * @return void
     */
    public static function getExtensionMethod()
    {
        \trigger_error('Class Nette\\Utils\\ObjectMixin is deprecated', \E_USER_DEPRECATED);
    }
}
