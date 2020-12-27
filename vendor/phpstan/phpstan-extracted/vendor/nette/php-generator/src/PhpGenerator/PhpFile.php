<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Nette\PhpGenerator;

use _HumbugBox221ad6f1b81f\Nette;
/**
 * Instance of PHP file.
 *
 * Generates:
 * - opening tag (<?php)
 * - doc comments
 * - one or more namespaces
 */
final class PhpFile
{
    use Nette\SmartObject;
    use Traits\CommentAware;
    /** @var PhpNamespace[] */
    private $namespaces = [];
    /** @var bool */
    private $strictTypes = \false;
    public function addClass(string $name) : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType
    {
        return $this->addNamespace(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::extractNamespace($name))->addClass(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::extractShortName($name));
    }
    public function addInterface(string $name) : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType
    {
        return $this->addNamespace(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::extractNamespace($name))->addInterface(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::extractShortName($name));
    }
    public function addTrait(string $name) : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\ClassType
    {
        return $this->addNamespace(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::extractNamespace($name))->addTrait(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Helpers::extractShortName($name));
    }
    /** @param  string|PhpNamespace  $namespace */
    public function addNamespace($namespace) : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\PhpNamespace
    {
        if ($namespace instanceof \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\PhpNamespace) {
            $res = $this->namespaces[$namespace->getName()] = $namespace;
        } elseif (\is_string($namespace)) {
            $res = $this->namespaces[$namespace] = $this->namespaces[$namespace] ?? new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\PhpNamespace($namespace);
        } else {
            throw new \_HumbugBox221ad6f1b81f\Nette\InvalidArgumentException('Argument must be string|PhpNamespace.');
        }
        foreach ($this->namespaces as $namespace) {
            $namespace->setBracketedSyntax(\count($this->namespaces) > 1 && isset($this->namespaces['']));
        }
        return $res;
    }
    /** @return PhpNamespace[] */
    public function getNamespaces() : array
    {
        return $this->namespaces;
    }
    /** @return static */
    public function addUse(string $name, string $alias = null) : self
    {
        $this->addNamespace('')->addUse($name, $alias);
        return $this;
    }
    /**
     * Adds declare(strict_types=1) to output.
     * @return static
     */
    public function setStrictTypes(bool $on = \true) : self
    {
        $this->strictTypes = $on;
        return $this;
    }
    public function hasStrictTypes() : bool
    {
        return $this->strictTypes;
    }
    /** @deprecated  use hasStrictTypes() */
    public function getStrictTypes() : bool
    {
        return $this->strictTypes;
    }
    public function __toString() : string
    {
        try {
            return (new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Printer())->printFile($this);
        } catch (\Throwable $e) {
            if (\PHP_VERSION_ID >= 70400) {
                throw $e;
            }
            \trigger_error('Exception in ' . __METHOD__ . "(): {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}", \E_USER_ERROR);
            return '';
        }
    }
}
