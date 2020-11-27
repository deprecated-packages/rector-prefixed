<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Nette\Utils;

if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString
    {
    }
} elseif (!\interface_exists(\_PhpScoperbd5d0c5f7638\Nette\Utils\IHtmlString::class)) {
    \class_alias(\_PhpScoperbd5d0c5f7638\Nette\HtmlStringable::class, \_PhpScoperbd5d0c5f7638\Nette\Utils\IHtmlString::class);
}
namespace _PhpScoperbd5d0c5f7638\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator
    {
    }
} elseif (!\interface_exists(\_PhpScoperbd5d0c5f7638\Nette\Localization\ITranslator::class)) {
    \class_alias(\_PhpScoperbd5d0c5f7638\Nette\Localization\Translator::class, \_PhpScoperbd5d0c5f7638\Nette\Localization\ITranslator::class);
}
