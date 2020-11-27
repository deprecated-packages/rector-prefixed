<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Nette\Utils;

if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString
    {
    }
} elseif (!\interface_exists(\_PhpScopera143bcca66cb\Nette\Utils\IHtmlString::class)) {
    \class_alias(\_PhpScopera143bcca66cb\Nette\HtmlStringable::class, \_PhpScopera143bcca66cb\Nette\Utils\IHtmlString::class);
}
namespace _PhpScopera143bcca66cb\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator
    {
    }
} elseif (!\interface_exists(\_PhpScopera143bcca66cb\Nette\Localization\ITranslator::class)) {
    \class_alias(\_PhpScopera143bcca66cb\Nette\Localization\Translator::class, \_PhpScopera143bcca66cb\Nette\Localization\ITranslator::class);
}
