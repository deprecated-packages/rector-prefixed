<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Utils\Strings;
/**
 * Assignment or calling statement.
 *
 * @property string|array|Definition|Reference|null $entity
 */
final class Statement implements \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Schema\DynamicParameter
{
    use Nette\SmartObject;
    /** @var array */
    public $arguments;
    /** @var string|array|Definition|Reference|null */
    private $entity;
    /**
     * @param  string|array|Definition|Reference|null  $entity
     */
    public function __construct($entity, array $arguments = [])
    {
        if ($entity !== null && !\is_string($entity) && !$entity instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Definition && !$entity instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Reference && !(\is_array($entity) && \array_keys($entity) === [0, 1] && (\is_string($entity[0]) || $entity[0] instanceof self || $entity[0] instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Reference || $entity[0] instanceof \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Definition))) {
            throw new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\InvalidArgumentException('Argument is not valid Statement entity.');
        }
        // normalize Class::method to [Class, method]
        if (\is_string($entity) && \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::contains($entity, '::') && !\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::contains($entity, '?')) {
            $entity = \explode('::', $entity);
        }
        if (\is_string($entity) && \substr($entity, 0, 1) === '@') {
            // normalize @service to Reference
            $entity = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Reference(\substr($entity, 1));
        } elseif (\is_array($entity) && \is_string($entity[0]) && \substr($entity[0], 0, 1) === '@') {
            $entity[0] = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Reference(\substr($entity[0], 1));
        }
        $this->entity = $entity;
        $this->arguments = $arguments;
    }
    /** @return string|array|Definition|Reference|null */
    public function getEntity()
    {
        return $this->entity;
    }
}
\class_exists(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Statement::class);
