<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Nette\Schema\Elements;

use _PhpScoper006a73f0e455\Nette;
use _PhpScoper006a73f0e455\Nette\Schema\Context;
use _PhpScoper006a73f0e455\Nette\Schema\DynamicParameter;
use _PhpScoper006a73f0e455\Nette\Schema\Helpers;
use _PhpScoper006a73f0e455\Nette\Schema\Schema;
final class Type implements \_PhpScoper006a73f0e455\Nette\Schema\Schema
{
    use Base;
    use Nette\SmartObject;
    /** @var string */
    private $type;
    /** @var Schema|null for arrays */
    private $items;
    /** @var array */
    private $range = [null, null];
    /** @var string|null */
    private $pattern;
    public function __construct(string $type)
    {
        static $defaults = ['list' => [], 'array' => []];
        $this->type = $type;
        $this->default = \strpos($type, '[]') ? [] : $defaults[$type] ?? null;
    }
    public function nullable() : self
    {
        $this->type .= '|null';
        return $this;
    }
    public function dynamic() : self
    {
        $this->type .= '|' . \_PhpScoper006a73f0e455\Nette\Schema\DynamicParameter::class;
        return $this;
    }
    public function min(?float $min) : self
    {
        $this->range[0] = $min;
        return $this;
    }
    public function max(?float $max) : self
    {
        $this->range[1] = $max;
        return $this;
    }
    /**
     * @param  string|Schema  $type
     * @internal  use arrayOf() or listOf()
     */
    public function items($type = 'mixed') : self
    {
        $this->items = $type instanceof \_PhpScoper006a73f0e455\Nette\Schema\Schema ? $type : new self($type);
        return $this;
    }
    public function pattern(?string $pattern) : self
    {
        $this->pattern = $pattern;
        return $this;
    }
    /********************* processing ****************d*g**/
    public function normalize($value, \_PhpScoper006a73f0e455\Nette\Schema\Context $context)
    {
        $value = $this->doNormalize($value, $context);
        if (\is_array($value) && $this->items) {
            foreach ($value as $key => $val) {
                $context->path[] = $key;
                $value[$key] = $this->items->normalize($val, $context);
                \array_pop($context->path);
            }
        }
        return $value;
    }
    public function merge($value, $base)
    {
        if (\is_array($value) && isset($value[\_PhpScoper006a73f0e455\Nette\Schema\Helpers::PREVENT_MERGING])) {
            unset($value[\_PhpScoper006a73f0e455\Nette\Schema\Helpers::PREVENT_MERGING]);
            return $value;
        }
        if (\is_array($value) && \is_array($base) && $this->items) {
            $index = 0;
            foreach ($value as $key => $val) {
                if ($key === $index) {
                    $base[] = $val;
                    $index++;
                } else {
                    $base[$key] = \array_key_exists($key, $base) ? $this->items->merge($val, $base[$key]) : $val;
                }
            }
            return $base;
        }
        return \_PhpScoper006a73f0e455\Nette\Schema\Helpers::merge($value, $base);
    }
    public function complete($value, \_PhpScoper006a73f0e455\Nette\Schema\Context $context)
    {
        if ($value === null && \is_array($this->default)) {
            $value = [];
            // is unable to distinguish null from array in NEON
        }
        $expected = $this->type . ($this->range === [null, null] ? '' : ':' . \implode('..', $this->range));
        if (!$this->doValidate($value, $expected, $context)) {
            return;
        }
        if ($this->pattern !== null && !\preg_match("\1^(?:{$this->pattern})\$\1Du", $value)) {
            $context->addError("The option %path% expects to match pattern '{$this->pattern}', '{$value}' given.");
            return;
        }
        if ($value instanceof \_PhpScoper006a73f0e455\Nette\Schema\DynamicParameter) {
            $context->dynamics[] = [$value, \str_replace('|' . \_PhpScoper006a73f0e455\Nette\Schema\DynamicParameter::class, '', $expected)];
        }
        if ($this->items) {
            $errCount = \count($context->errors);
            foreach ($value as $key => $val) {
                $context->path[] = $key;
                $value[$key] = $this->items->complete($val, $context);
                \array_pop($context->path);
            }
            if (\count($context->errors) > $errCount) {
                return null;
            }
        }
        $value = \_PhpScoper006a73f0e455\Nette\Schema\Helpers::merge($value, $this->default);
        return $this->doFinalize($value, $context);
    }
}
