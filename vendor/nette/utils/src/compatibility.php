<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix2020DecSat\Nette\Utils;

if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString
    {
    }
} elseif (!\interface_exists(\RectorPrefix2020DecSat\Nette\Utils\IHtmlString::class)) {
    \class_alias(\RectorPrefix2020DecSat\Nette\HtmlStringable::class, \RectorPrefix2020DecSat\Nette\Utils\IHtmlString::class);
}
namespace RectorPrefix2020DecSat\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator
    {
    }
} elseif (!\interface_exists(\RectorPrefix2020DecSat\Nette\Localization\ITranslator::class)) {
    \class_alias(\RectorPrefix2020DecSat\Nette\Localization\Translator::class, \RectorPrefix2020DecSat\Nette\Localization\ITranslator::class);
}
