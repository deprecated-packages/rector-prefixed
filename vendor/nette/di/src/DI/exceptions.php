<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Nette\DI;

use _PhpScoperbd5d0c5f7638\Nette;
/**
 * Service not found exception.
 */
class MissingServiceException extends \_PhpScoperbd5d0c5f7638\Nette\InvalidStateException
{
}
/**
 * Service creation exception.
 */
class ServiceCreationException extends \_PhpScoperbd5d0c5f7638\Nette\InvalidStateException
{
    public function setMessage(string $message) : self
    {
        $this->message = $message;
        return $this;
    }
}
/**
 * Not allowed when container is resolving.
 */
class NotAllowedDuringResolvingException extends \_PhpScoperbd5d0c5f7638\Nette\InvalidStateException
{
}
/**
 * Error in configuration.
 */
class InvalidConfigurationException extends \_PhpScoperbd5d0c5f7638\Nette\InvalidStateException
{
}
