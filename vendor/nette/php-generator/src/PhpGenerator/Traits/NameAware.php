<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Nette\PhpGenerator\Traits;

use _PhpScoper88fe6e0ad041\Nette;
/**
 * @internal
 */
trait NameAware
{
    /** @var string */
    private $name;
    public function __construct(string $name)
    {
        if (!\_PhpScoper88fe6e0ad041\Nette\PhpGenerator\Helpers::isIdentifier($name)) {
            throw new \_PhpScoper88fe6e0ad041\Nette\InvalidArgumentException("Value '{$name}' is not valid name.");
        }
        $this->name = $name;
    }
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * Returns clone with a different name.
     * @return static
     */
    public function cloneWithName(string $name) : self
    {
        $dolly = clone $this;
        $dolly->__construct($name);
        return $dolly;
    }
}
