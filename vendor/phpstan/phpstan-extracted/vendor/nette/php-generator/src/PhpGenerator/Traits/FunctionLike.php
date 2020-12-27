<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Nette\PhpGenerator\Traits;

use _HumbugBox221ad6f1b81f\Nette;
use _HumbugBox221ad6f1b81f\Nette\PhpGenerator\Dumper;
use _HumbugBox221ad6f1b81f\Nette\PhpGenerator\Parameter;
/**
 * @internal
 */
trait FunctionLike
{
    /** @var string */
    private $body = '';
    /** @var Parameter[] */
    private $parameters = [];
    /** @var bool */
    private $variadic = \false;
    /** @var string|null */
    private $returnType;
    /** @var bool */
    private $returnReference = \false;
    /** @var bool */
    private $returnNullable = \false;
    /** @return static */
    public function setBody(string $code, array $args = null) : self
    {
        $this->body = $args === null ? $code : (new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Dumper())->format($code, ...$args);
        return $this;
    }
    public function getBody() : string
    {
        return $this->body;
    }
    /** @return static */
    public function addBody(string $code, array $args = null) : self
    {
        $this->body .= ($args === null ? $code : (new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Dumper())->format($code, ...$args)) . "\n";
        return $this;
    }
    /**
     * @param  Parameter[]  $val
     * @return static
     */
    public function setParameters(array $val) : self
    {
        $this->parameters = [];
        foreach ($val as $v) {
            if (!$v instanceof \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Parameter) {
                throw new \_HumbugBox221ad6f1b81f\Nette\InvalidArgumentException('Argument must be Nette\\PhpGenerator\\Parameter[].');
            }
            $this->parameters[$v->getName()] = $v;
        }
        return $this;
    }
    /** @return Parameter[] */
    public function getParameters() : array
    {
        return $this->parameters;
    }
    /**
     * @param  string  $name without $
     */
    public function addParameter(string $name, $defaultValue = null) : \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Parameter
    {
        $param = new \_HumbugBox221ad6f1b81f\Nette\PhpGenerator\Parameter($name);
        if (\func_num_args() > 1) {
            $param->setDefaultValue($defaultValue);
        }
        return $this->parameters[$name] = $param;
    }
    /**
     * @param  string  $name without $
     * @return static
     */
    public function removeParameter(string $name) : self
    {
        unset($this->parameters[$name]);
        return $this;
    }
    /** @return static */
    public function setVariadic(bool $state = \true) : self
    {
        $this->variadic = $state;
        return $this;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
    /** @return static */
    public function setReturnType(?string $val) : self
    {
        $this->returnType = $val;
        return $this;
    }
    public function getReturnType() : ?string
    {
        return $this->returnType;
    }
    /** @return static */
    public function setReturnReference(bool $state = \true) : self
    {
        $this->returnReference = $state;
        return $this;
    }
    public function getReturnReference() : bool
    {
        return $this->returnReference;
    }
    /** @return static */
    public function setReturnNullable(bool $state = \true) : self
    {
        $this->returnNullable = $state;
        return $this;
    }
    public function isReturnNullable() : bool
    {
        return $this->returnNullable;
    }
    /** @deprecated  use isReturnNullable() */
    public function getReturnNullable() : bool
    {
        return $this->returnNullable;
    }
    /** @deprecated */
    public function setNamespace(\_HumbugBox221ad6f1b81f\Nette\PhpGenerator\PhpNamespace $val = null) : self
    {
        \trigger_error(__METHOD__ . '() is deprecated', \E_USER_DEPRECATED);
        return $this;
    }
}
