<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f__UniqueRector\Nette\DI\Definitions;

use _HumbugBox221ad6f1b81f__UniqueRector\Nette;
use _HumbugBox221ad6f1b81f__UniqueRector\Nette\DI\PhpGenerator;
/**
 * Imported service injected to the container.
 */
final class ImportedDefinition extends \_HumbugBox221ad6f1b81f__UniqueRector\Nette\DI\Definitions\Definition
{
    /** @return static */
    public function setType(?string $type)
    {
        return parent::setType($type);
    }
    public function resolveType(\_HumbugBox221ad6f1b81f__UniqueRector\Nette\DI\Resolver $resolver) : void
    {
    }
    public function complete(\_HumbugBox221ad6f1b81f__UniqueRector\Nette\DI\Resolver $resolver) : void
    {
    }
    public function generateMethod(\_HumbugBox221ad6f1b81f__UniqueRector\Nette\PhpGenerator\Method $method, \_HumbugBox221ad6f1b81f__UniqueRector\Nette\DI\PhpGenerator $generator) : void
    {
        $method->setReturnType('void')->setBody('throw new Nette\\DI\\ServiceCreationException(?);', ["Unable to create imported service '{$this->getName()}', it must be added using addService()"]);
    }
    /** @deprecated use '$def instanceof ImportedDefinition' */
    public function isDynamic() : bool
    {
        return \true;
    }
}
