<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Elements;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Context;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Helpers;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Schema;
final class AnyOf implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
{
    use Base;
    use Nette\SmartObject;
    /** @var array */
    private $set;
    /**
     * @param  mixed|Schema  ...$set
     */
    public function __construct(...$set)
    {
        $this->set = $set;
    }
    public function nullable() : self
    {
        $this->set[] = null;
        return $this;
    }
    public function dynamic() : self
    {
        $this->set[] = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Type(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\DynamicParameter::class);
        return $this;
    }
    /********************* processing ****************d*g**/
    public function normalize($value, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context)
    {
        return $this->doNormalize($value, $context);
    }
    public function merge($value, $base)
    {
        if (\is_array($value) && isset($value[\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Helpers::PREVENT_MERGING])) {
            unset($value[\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Helpers::PREVENT_MERGING]);
            return $value;
        }
        return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Helpers::merge($value, $base);
    }
    public function complete($value, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context)
    {
        $hints = $innerErrors = [];
        foreach ($this->set as $item) {
            if ($item instanceof \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Schema) {
                $dolly = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Context();
                $dolly->path = $context->path;
                $res = $item->complete($value, $dolly);
                if (!$dolly->errors) {
                    return $this->doFinalize($res, $context);
                }
                foreach ($dolly->errors as $error) {
                    if ($error->path !== $context->path || !$error->hint) {
                        $innerErrors[] = $error;
                    } else {
                        $hints[] = $error->hint;
                    }
                }
            } else {
                if ($item === $value) {
                    return $this->doFinalize($value, $context);
                }
                $hints[] = static::formatValue($item);
            }
        }
        if ($innerErrors) {
            $context->errors = \array_merge($context->errors, $innerErrors);
        } else {
            $hints = \implode('|', \array_unique($hints));
            $context->addError("The option %path% expects to be {$hints}, " . static::formatValue($value) . ' given.');
        }
    }
    public function completeDefault(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context)
    {
        if ($this->required) {
            $context->addError('The mandatory option %path% is missing.');
            return null;
        }
        if ($this->default instanceof \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Nette\Schema\Schema) {
            return $this->default->completeDefault($context);
        }
        return $this->default;
    }
}
