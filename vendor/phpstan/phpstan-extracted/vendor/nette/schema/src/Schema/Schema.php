<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema;

interface Schema
{
    /**
     * Normalization.
     * @return mixed
     */
    function normalize($value, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context);
    /**
     * Merging.
     * @return mixed
     */
    function merge($value, $base);
    /**
     * Validation and finalization.
     * @return mixed
     */
    function complete($value, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context);
    /**
     * @return mixed
     */
    function completeDefault(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context);
}
