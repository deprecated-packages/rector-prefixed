<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Nette\Utils;

if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString
    {
    }
} elseif (!\interface_exists(\_PhpScoper26e51eeacccf\Nette\Utils\IHtmlString::class)) {
    \class_alias(\_PhpScoper26e51eeacccf\Nette\HtmlStringable::class, \_PhpScoper26e51eeacccf\Nette\Utils\IHtmlString::class);
}
namespace _PhpScoper26e51eeacccf\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator
    {
    }
} elseif (!\interface_exists(\_PhpScoper26e51eeacccf\Nette\Localization\ITranslator::class)) {
    \class_alias(\_PhpScoper26e51eeacccf\Nette\Localization\Translator::class, \_PhpScoper26e51eeacccf\Nette\Localization\ITranslator::class);
}
