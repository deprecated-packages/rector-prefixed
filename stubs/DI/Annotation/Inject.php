<?php

declare (strict_types=1);
// source: https://github.com/PHP-DI/PHP-DI/blob/master/src/Annotation/Inject.php
namespace _PhpScoperbd5d0c5f7638\DI\Annotation;

if (\class_exists('_PhpScoperbd5d0c5f7638\\DI\\Annotation\\Inject')) {
    return;
}
/**
 * @Annotation
 * @Target({"METHOD","PROPERTY"})
 */
final class Inject
{
    /**
     * @var string|null
     */
    private $name;
    /**
     * @var array
     */
    private $parameters = [];
    public function getName() : ?string
    {
        return $this->name;
    }
    public function getParameters() : array
    {
        return $this->parameters;
    }
}
