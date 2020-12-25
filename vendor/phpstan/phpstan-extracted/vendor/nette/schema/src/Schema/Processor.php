<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Nette\Schema;

use _HumbugBox221ad6f1b81f\Nette;
/**
 * Schema validator.
 */
final class Processor
{
    use Nette\SmartObject;
    /** @var array */
    public $onNewContext = [];
    /** @var bool */
    private $skipDefaults;
    public function skipDefaults(bool $value = \true)
    {
        $this->skipDefaults = $value;
    }
    /**
     * Normalizes and validates data. Result is a clean completed data.
     * @return mixed
     * @throws ValidationException
     */
    public function process(\_HumbugBox221ad6f1b81f\Nette\Schema\Schema $schema, $data)
    {
        $context = $this->createContext();
        $data = $schema->normalize($data, $context);
        $this->throwsErrors($context);
        $data = $schema->complete($data, $context);
        $this->throwsErrors($context);
        return $data;
    }
    /**
     * Normalizes and validates and merges multiple data. Result is a clean completed data.
     * @return mixed
     * @throws ValidationException
     */
    public function processMultiple(\_HumbugBox221ad6f1b81f\Nette\Schema\Schema $schema, array $dataset)
    {
        $context = $this->createContext();
        $flatten = null;
        $first = \true;
        foreach ($dataset as $data) {
            $data = $schema->normalize($data, $context);
            $this->throwsErrors($context);
            $flatten = $first ? $data : $schema->merge($data, $flatten);
            $first = \false;
        }
        $data = $schema->complete($flatten, $context);
        $this->throwsErrors($context);
        return $data;
    }
    private function throwsErrors(\_HumbugBox221ad6f1b81f\Nette\Schema\Context $context) : void
    {
        $messages = [];
        foreach ($context->errors as $error) {
            $pathStr = " '" . \implode(' › ', $error->path) . "'";
            $messages[] = \str_replace(' %path%', $error->path ? $pathStr : '', $error->message);
        }
        if ($messages) {
            throw new \_HumbugBox221ad6f1b81f\Nette\Schema\ValidationException($messages[0], $messages);
        }
    }
    private function createContext() : \_HumbugBox221ad6f1b81f\Nette\Schema\Context
    {
        $context = new \_HumbugBox221ad6f1b81f\Nette\Schema\Context();
        $context->skipDefaults = $this->skipDefaults;
        $this->onNewContext($context);
        return $context;
    }
}
