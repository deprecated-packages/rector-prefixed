<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Nette\Schema;

interface Schema
{
    /**
     * Normalization.
     * @return mixed
     */
    function normalize($value, \_PhpScoperbd5d0c5f7638\Nette\Schema\Context $context);
    /**
     * Merging.
     * @return mixed
     */
    function merge($value, $base);
    /**
     * Validation and finalization.
     * @return mixed
     */
    function complete($value, \_PhpScoperbd5d0c5f7638\Nette\Schema\Context $context);
    /**
     * @return mixed
     */
    function completeDefault(\_PhpScoperbd5d0c5f7638\Nette\Schema\Context $context);
}
