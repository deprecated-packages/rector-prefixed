<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI;

use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette;
/**
 * Service not found exception.
 */
class MissingServiceException extends \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\InvalidStateException
{
}
/**
 * Service creation exception.
 */
class ServiceCreationException extends \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\InvalidStateException
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
class NotAllowedDuringResolvingException extends \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\InvalidStateException
{
}
/**
 * Error in configuration.
 */
class InvalidConfigurationException extends \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\InvalidStateException
{
}
