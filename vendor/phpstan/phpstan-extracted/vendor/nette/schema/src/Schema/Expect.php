<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Nette\Schema;

use _HumbugBox221ad6f1b81f\Nette;
use _HumbugBox221ad6f1b81f\Nette\Schema\Elements\AnyOf;
use _HumbugBox221ad6f1b81f\Nette\Schema\Elements\Structure;
use _HumbugBox221ad6f1b81f\Nette\Schema\Elements\Type;
/**
 * Schema generator.
 *
 * @method static Type scalar($default = null)
 * @method static Type string($default = null)
 * @method static Type int($default = null)
 * @method static Type float($default = null)
 * @method static Type bool($default = null)
 * @method static Type null()
 * @method static Type array($default = [])
 * @method static Type list($default = [])
 * @method static Type mixed($default = null)
 * @method static Type email($default = null)
 */
final class Expect
{
    use Nette\SmartObject;
    public static function __callStatic(string $name, array $args) : \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Type
    {
        $type = new \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Type($name);
        if ($args) {
            $type->default($args[0]);
        }
        return $type;
    }
    public static function type(string $type) : \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Type
    {
        return new \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Type($type);
    }
    /**
     * @param  mixed|Schema  ...$set
     */
    public static function anyOf(...$set) : \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\AnyOf
    {
        return new \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\AnyOf(...$set);
    }
    /**
     * @param  Schema[]  $items
     */
    public static function structure(array $items) : \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Structure
    {
        return new \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Structure($items);
    }
    /**
     * @param  object  $object
     */
    public static function from($object, array $items = []) : \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Structure
    {
        $ro = new \ReflectionObject($object);
        foreach ($ro->getProperties() as $prop) {
            $type = \_HumbugBox221ad6f1b81f\Nette\Schema\Helpers::getPropertyType($prop) ?? 'mixed';
            $item =& $items[$prop->getName()];
            if (!$item) {
                $item = new \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Type($type);
                if (\PHP_VERSION_ID >= 70400 && !$prop->isInitialized($object)) {
                    $item->required();
                } else {
                    $def = $prop->getValue($object);
                    if (\is_object($def)) {
                        $item = static::from($def);
                    } elseif ($def === null && !\_HumbugBox221ad6f1b81f\Nette\Utils\Validators::is(null, $type)) {
                        $item->required();
                    } else {
                        $item->default($def);
                    }
                }
            }
        }
        return (new \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Structure($items))->castTo($ro->getName());
    }
    /**
     * @param  string|Schema  $type
     */
    public static function arrayOf($type) : \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Type
    {
        return (new \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Type('array'))->items($type);
    }
    /**
     * @param  string|Schema  $type
     */
    public static function listOf($type) : \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Type
    {
        return (new \_HumbugBox221ad6f1b81f\Nette\Schema\Elements\Type('list'))->items($type);
    }
}
