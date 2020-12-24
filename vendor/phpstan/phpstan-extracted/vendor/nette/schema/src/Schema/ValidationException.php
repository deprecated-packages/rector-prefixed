<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette;
/**
 * Validation error.
 */
class ValidationException extends \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\InvalidStateException
{
    /** @var array */
    private $messages;
    public function __construct(string $message, array $messages = [])
    {
        parent::__construct($message);
        $this->messages = $messages ?: [$message];
    }
    public function getMessages() : array
    {
        return $this->messages;
    }
}
