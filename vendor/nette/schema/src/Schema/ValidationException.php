<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Nette\Schema;

use _PhpScoperabd03f0baf05\Nette;
/**
 * Validation error.
 */
class ValidationException extends \_PhpScoperabd03f0baf05\Nette\InvalidStateException
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
