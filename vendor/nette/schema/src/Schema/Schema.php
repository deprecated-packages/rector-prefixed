<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Nette\Schema;

interface Schema
{
    /**
     * Normalization.
     * @return mixed
     */
    function normalize($value, \_PhpScoper006a73f0e455\Nette\Schema\Context $context);
    /**
     * Merging.
     * @return mixed
     */
    function merge($value, $base);
    /**
     * Validation and finalization.
     * @return mixed
     */
    function complete($value, \_PhpScoper006a73f0e455\Nette\Schema\Context $context);
    /**
     * @return mixed
     */
    function completeDefault(\_PhpScoper006a73f0e455\Nette\Schema\Context $context);
}
