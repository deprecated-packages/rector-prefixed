<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Nette\PhpGenerator;

/**
 * Generates PHP code compatible with PSR-2 and PSR-12.
 */
final class PsrPrinter extends \_PhpScoper88fe6e0ad041\Nette\PhpGenerator\Printer
{
    /** @var string */
    protected $indentation = '    ';
    /** @var int */
    protected $linesBetweenMethods = 1;
}
