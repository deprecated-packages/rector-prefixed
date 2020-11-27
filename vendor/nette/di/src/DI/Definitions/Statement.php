<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Nette\DI\Definitions;

use _PhpScoper006a73f0e455\Nette;
use _PhpScoper006a73f0e455\Nette\Utils\Strings;
/**
 * Assignment or calling statement.
 *
 * @property string|array|Definition|Reference|null $entity
 */
final class Statement implements \_PhpScoper006a73f0e455\Nette\Schema\DynamicParameter
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
        if ($entity !== null && !\is_string($entity) && !$entity instanceof \_PhpScoper006a73f0e455\Nette\DI\Definitions\Definition && !$entity instanceof \_PhpScoper006a73f0e455\Nette\DI\Definitions\Reference && !(\is_array($entity) && \array_keys($entity) === [0, 1] && (\is_string($entity[0]) || $entity[0] instanceof self || $entity[0] instanceof \_PhpScoper006a73f0e455\Nette\DI\Definitions\Reference || $entity[0] instanceof \_PhpScoper006a73f0e455\Nette\DI\Definitions\Definition))) {
            throw new \_PhpScoper006a73f0e455\Nette\InvalidArgumentException('Argument is not valid Statement entity.');
        }
        // normalize Class::method to [Class, method]
        if (\is_string($entity) && \_PhpScoper006a73f0e455\Nette\Utils\Strings::contains($entity, '::') && !\_PhpScoper006a73f0e455\Nette\Utils\Strings::contains($entity, '?')) {
            $entity = \explode('::', $entity);
        }
        if (\is_string($entity) && \substr($entity, 0, 1) === '@') {
            // normalize @service to Reference
            $entity = new \_PhpScoper006a73f0e455\Nette\DI\Definitions\Reference(\substr($entity, 1));
        } elseif (\is_array($entity) && \is_string($entity[0]) && \substr($entity[0], 0, 1) === '@') {
            $entity[0] = new \_PhpScoper006a73f0e455\Nette\DI\Definitions\Reference(\substr($entity[0], 1));
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
\class_exists(\_PhpScoper006a73f0e455\Nette\DI\Statement::class);
