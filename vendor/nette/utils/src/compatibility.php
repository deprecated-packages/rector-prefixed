<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Nette\Utils;

if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString
    {
    }
} elseif (!\interface_exists(\_PhpScoper88fe6e0ad041\Nette\Utils\IHtmlString::class)) {
    \class_alias(\_PhpScoper88fe6e0ad041\Nette\HtmlStringable::class, \_PhpScoper88fe6e0ad041\Nette\Utils\IHtmlString::class);
}
namespace _PhpScoper88fe6e0ad041\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator
    {
    }
} elseif (!\interface_exists(\_PhpScoper88fe6e0ad041\Nette\Localization\ITranslator::class)) {
    \class_alias(\_PhpScoper88fe6e0ad041\Nette\Localization\Translator::class, \_PhpScoper88fe6e0ad041\Nette\Localization\ITranslator::class);
}