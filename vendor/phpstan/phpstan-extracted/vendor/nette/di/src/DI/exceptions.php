<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f__UniqueRector\Nette\DI;

use _HumbugBox221ad6f1b81f__UniqueRector\Nette;
/**
 * Service not found exception.
 */
class MissingServiceException extends \_HumbugBox221ad6f1b81f__UniqueRector\Nette\InvalidStateException
{
}
/**
 * Service creation exception.
 */
class ServiceCreationException extends \_HumbugBox221ad6f1b81f__UniqueRector\Nette\InvalidStateException
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
class NotAllowedDuringResolvingException extends \_HumbugBox221ad6f1b81f__UniqueRector\Nette\InvalidStateException
{
}
/**
 * Error in configuration.
 */
class InvalidConfigurationException extends \_HumbugBox221ad6f1b81f__UniqueRector\Nette\InvalidStateException
{
}
