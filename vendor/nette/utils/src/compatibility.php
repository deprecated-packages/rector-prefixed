<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper267b3276efc2\Nette\Utils;

if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString
    {
    }
} elseif (!\interface_exists(\_PhpScoper267b3276efc2\Nette\Utils\IHtmlString::class)) {
    \class_alias(\_PhpScoper267b3276efc2\Nette\HtmlStringable::class, \_PhpScoper267b3276efc2\Nette\Utils\IHtmlString::class);
}
namespace _PhpScoper267b3276efc2\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator
    {
    }
} elseif (!\interface_exists(\_PhpScoper267b3276efc2\Nette\Localization\ITranslator::class)) {
    \class_alias(\_PhpScoper267b3276efc2\Nette\Localization\Translator::class, \_PhpScoper267b3276efc2\Nette\Localization\ITranslator::class);
}
