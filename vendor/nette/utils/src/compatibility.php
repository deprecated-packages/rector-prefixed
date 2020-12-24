<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Nette\Utils;

if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString
    {
    }
} elseif (!\interface_exists(\_PhpScoperb75b35f52b74\Nette\Utils\IHtmlString::class)) {
    \class_alias(\_PhpScoperb75b35f52b74\Nette\HtmlStringable::class, \_PhpScoperb75b35f52b74\Nette\Utils\IHtmlString::class);
}
namespace _PhpScoperb75b35f52b74\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator
    {
    }
} elseif (!\interface_exists(\_PhpScoperb75b35f52b74\Nette\Localization\ITranslator::class)) {
    \class_alias(\_PhpScoperb75b35f52b74\Nette\Localization\Translator::class, \_PhpScoperb75b35f52b74\Nette\Localization\ITranslator::class);
}
