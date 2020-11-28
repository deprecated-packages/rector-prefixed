<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Gedmo\Mapping\Annotation;

if (\class_exists('_PhpScoperabd03f0baf05\\Gedmo\\Mapping\\Annotation\\Slug')) {
    return;
}
/**
 * @Annotation
 */
class Slug
{
    /** @var array<string> @Required */
    public $fields = array();
    /** @var boolean */
    public $updatable = \true;
    /** @var string */
    public $style = 'default';
    // or "camel"
    /** @var boolean */
    public $unique = \true;
    /** @var string */
    public $unique_base = null;
    /** @var string */
    public $separator = '-';
    /** @var string */
    public $prefix = '';
    /** @var string */
    public $suffix = '';
    public $handlers = array();
    /** @var string */
    public $dateFormat = 'Y-m-d-H:i';
}
