<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Nette\Utils;

if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString
    {
    }
} elseif (!\interface_exists(\_PhpScoperbf340cb0be9d\Nette\Utils\IHtmlString::class)) {
    \class_alias(\_PhpScoperbf340cb0be9d\Nette\HtmlStringable::class, \_PhpScoperbf340cb0be9d\Nette\Utils\IHtmlString::class);
}
namespace _PhpScoperbf340cb0be9d\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator
    {
    }
} elseif (!\interface_exists(\_PhpScoperbf340cb0be9d\Nette\Localization\ITranslator::class)) {
    \class_alias(\_PhpScoperbf340cb0be9d\Nette\Localization\Translator::class, \_PhpScoperbf340cb0be9d\Nette\Localization\ITranslator::class);
}
