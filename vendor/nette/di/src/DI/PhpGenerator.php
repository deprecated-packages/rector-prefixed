<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Nette\DI;

use _PhpScoper88fe6e0ad041\Nette;
use _PhpScoper88fe6e0ad041\Nette\DI\Definitions\Reference;
use _PhpScoper88fe6e0ad041\Nette\DI\Definitions\Statement;
use _PhpScoper88fe6e0ad041\Nette\PhpGenerator as Php;
use _PhpScoper88fe6e0ad041\Nette\Utils\Strings;
/**
 * Container PHP code generator.
 */
class PhpGenerator
{
    use Nette\SmartObject;
    /** @var ContainerBuilder */
    private $builder;
    /** @var string */
    private $className;
    public function __construct(\_PhpScoper88fe6e0ad041\Nette\DI\ContainerBuilder $builder)
    {
        $this->builder = $builder;
    }
    /**
     * Generates PHP classes. First class is the container.
     */
    public function generate(string $className) : \_PhpScoper88fe6e0ad041\Nette\PhpGenerator\ClassType
    {
        $this->className = $className;
        $class = new \_PhpScoper88fe6e0ad041\Nette\PhpGenerator\ClassType($this->className);
        $class->setExtends(\_PhpScoper88fe6e0ad041\Nette\DI\Container::class);
        $class->addMethod('__construct')->addBody('parent::__construct($params);')->addParameter('params', [])->setType('array');
        foreach ($this->builder->exportMeta() as $key => $value) {
            $class->addProperty($key)->setProtected()->setValue($value);
        }
        $definitions = $this->builder->getDefinitions();
        \ksort($definitions);
        foreach ($definitions as $def) {
            $class->addMember($this->generateMethod($def));
        }
        $class->getMethod(\_PhpScoper88fe6e0ad041\Nette\DI\Container::getMethodName(\_PhpScoper88fe6e0ad041\Nette\DI\ContainerBuilder::THIS_CONTAINER))->setReturnType($className)->setBody('return $this;');
        $class->addMethod('initialize');
        return $class;
    }
    public function toString(\_PhpScoper88fe6e0ad041\Nette\PhpGenerator\ClassType $class) : string
    {
        return '/** @noinspection PhpParamsInspection,PhpMethodMayBeStaticInspection */

declare(strict_types=1);

' . $class->__toString();
    }
    public function addInitialization(\_PhpScoper88fe6e0ad041\Nette\PhpGenerator\ClassType $class, \_PhpScoper88fe6e0ad041\Nette\DI\CompilerExtension $extension) : void
    {
        $closure = $extension->getInitialization();
        if ($closure->getBody()) {
            $class->getMethod('initialize')->addBody('// ' . $extension->prefix(''))->addBody("({$closure})();");
        }
    }
    public function generateMethod(\_PhpScoper88fe6e0ad041\Nette\DI\Definitions\Definition $def) : \_PhpScoper88fe6e0ad041\Nette\PhpGenerator\Method
    {
        $name = $def->getName();
        try {
            $method = new \_PhpScoper88fe6e0ad041\Nette\PhpGenerator\Method(\_PhpScoper88fe6e0ad041\Nette\DI\Container::getMethodName($name));
            $method->setPublic();
            $method->setReturnType($def->getType());
            $def->generateMethod($method, $this);
            return $method;
        } catch (\Exception $e) {
            throw new \_PhpScoper88fe6e0ad041\Nette\DI\ServiceCreationException("Service '{$name}': " . $e->getMessage(), 0, $e);
        }
    }
    /**
     * Formats PHP code for class instantiating, function calling or property setting in PHP.
     */
    public function formatStatement(\_PhpScoper88fe6e0ad041\Nette\DI\Definitions\Statement $statement) : string
    {
        $entity = $statement->getEntity();
        $arguments = $statement->arguments;
        switch (\true) {
            case \is_string($entity) && \_PhpScoper88fe6e0ad041\Nette\Utils\Strings::contains($entity, '?'):
                // PHP literal
                return $this->formatPhp($entity, $arguments);
            case \is_string($entity):
                // create class
                return $this->formatPhp("new {$entity}" . ($arguments ? '(...?)' : ''), $arguments ? [$arguments] : []);
            case \is_array($entity):
                switch (\true) {
                    case $entity[1][0] === '$':
                        // property getter, setter or appender
                        $name = \substr($entity[1], 1);
                        if ($append = \substr($name, -2) === '[]') {
                            $name = \substr($name, 0, -2);
                        }
                        $prop = $entity[0] instanceof \_PhpScoper88fe6e0ad041\Nette\DI\Definitions\Reference ? $this->formatPhp('?->?', [$entity[0], $name]) : $this->formatPhp($entity[0] . '::$?', [$name]);
                        return $arguments ? $this->formatPhp($prop . ($append ? '[]' : '') . ' = ?', [$arguments[0]]) : $prop;
                    case $entity[0] instanceof \_PhpScoper88fe6e0ad041\Nette\DI\Definitions\Statement:
                        $inner = $this->formatPhp('?', [$entity[0]]);
                        if (\substr($inner, 0, 4) === 'new ') {
                            $inner = "({$inner})";
                        }
                        return $this->formatPhp("{$inner}->?(...?)", [$entity[1], $arguments]);
                    case $entity[0] instanceof \_PhpScoper88fe6e0ad041\Nette\DI\Definitions\Reference:
                        return $this->formatPhp('?->?(...?)', [$entity[0], $entity[1], $arguments]);
                    case $entity[0] === '':
                        // function call
                        return $this->formatPhp("{$entity[1]}(...?)", [$arguments]);
                    case \is_string($entity[0]):
                        // static method call
                        return $this->formatPhp("{$entity[0]}::{$entity[1]}(...?)", [$arguments]);
                }
        }
        throw new \_PhpScoper88fe6e0ad041\Nette\InvalidStateException();
    }
    /**
     * Formats PHP statement.
     * @internal
     */
    public function formatPhp(string $statement, array $args) : string
    {
        \array_walk_recursive($args, function (&$val) : void {
            if ($val instanceof \_PhpScoper88fe6e0ad041\Nette\DI\Definitions\Statement) {
                $val = new \_PhpScoper88fe6e0ad041\Nette\PhpGenerator\Literal($this->formatStatement($val));
            } elseif ($val instanceof \_PhpScoper88fe6e0ad041\Nette\DI\Definitions\Reference) {
                $name = $val->getValue();
                if ($val->isSelf()) {
                    $val = new \_PhpScoper88fe6e0ad041\Nette\PhpGenerator\Literal('$service');
                } elseif ($name === \_PhpScoper88fe6e0ad041\Nette\DI\ContainerBuilder::THIS_CONTAINER) {
                    $val = new \_PhpScoper88fe6e0ad041\Nette\PhpGenerator\Literal('$this');
                } else {
                    $val = \_PhpScoper88fe6e0ad041\Nette\DI\ContainerBuilder::literal('$this->getService(?)', [$name]);
                }
            }
        });
        return \_PhpScoper88fe6e0ad041\Nette\PhpGenerator\Helpers::formatArgs($statement, $args);
    }
    /**
     * Converts parameters from Definition to PhpGenerator.
     * @return Php\Parameter[]
     */
    public function convertParameters(array $parameters) : array
    {
        $res = [];
        foreach ($parameters as $k => $v) {
            $tmp = \explode(' ', \is_int($k) ? $v : $k);
            $param = $res[] = new \_PhpScoper88fe6e0ad041\Nette\PhpGenerator\Parameter(\end($tmp));
            if (!\is_int($k)) {
                $param->setDefaultValue($v);
            }
            if (isset($tmp[1])) {
                $param->setType($tmp[0]);
            }
        }
        return $res;
    }
    public function getClassName() : ?string
    {
        return $this->className;
    }
}
