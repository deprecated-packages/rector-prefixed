<?php

/**
 * This file is part of the Tracy (https://tracy.nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210504\Tracy\Dumper;

/**
 * Exposes internal PHP objects.
 * @internal
 */
final class Exposer
{
    /**
     * @param object $obj
     */
    public static function exposeObject($obj, \RectorPrefix20210504\Tracy\Dumper\Value $value, \RectorPrefix20210504\Tracy\Dumper\Describer $describer) : void
    {
        $tmp = (array) $obj;
        $values = $tmp;
        // bug #79477, PHP < 7.4.6
        $props = self::getProperties(\get_class($obj));
        foreach (\array_diff_key($values, $props) as $k => $v) {
            $describer->addPropertyTo($value, (string) $k, $v, \RectorPrefix20210504\Tracy\Dumper\Value::PROP_DYNAMIC, $describer->getReferenceId($values, $k));
        }
        foreach ($props as $k => [$name, $class, $type]) {
            if (\array_key_exists($k, $values)) {
                $describer->addPropertyTo($value, $name, $values[$k], $type, $describer->getReferenceId($values, $k), $class);
            } else {
                $value->items[] = [$name, new \RectorPrefix20210504\Tracy\Dumper\Value(\RectorPrefix20210504\Tracy\Dumper\Value::TYPE_TEXT, 'unset'), $type === \RectorPrefix20210504\Tracy\Dumper\Value::PROP_PRIVATE ? $class : $type];
            }
        }
    }
    private static function getProperties($class) : array
    {
        static $cache;
        if (isset($cache[$class])) {
            return $cache[$class];
        }
        $rc = new \ReflectionClass($class);
        $parentProps = $rc->getParentClass() ? self::getProperties($rc->getParentClass()->getName()) : [];
        $props = [];
        foreach ($rc->getProperties() as $prop) {
            $name = $prop->getName();
            if ($prop->isStatic() || $prop->getDeclaringClass()->getName() !== $class) {
                // nothing
            } elseif ($prop->isPrivate()) {
                $props["\0" . $class . "\0" . $name] = [$name, $class, \RectorPrefix20210504\Tracy\Dumper\Value::PROP_PRIVATE];
            } elseif ($prop->isProtected()) {
                $props["\0*\0" . $name] = [$name, $class, \RectorPrefix20210504\Tracy\Dumper\Value::PROP_PROTECTED];
            } else {
                $props[$name] = [$name, $class, \RectorPrefix20210504\Tracy\Dumper\Value::PROP_PUBLIC];
                unset($parentProps["\0*\0" . $name]);
            }
        }
        return $cache[$class] = $props + $parentProps;
    }
    public static function exposeClosure(\Closure $obj, \RectorPrefix20210504\Tracy\Dumper\Value $value, \RectorPrefix20210504\Tracy\Dumper\Describer $describer) : void
    {
        $rc = new \ReflectionFunction($obj);
        if ($describer->location) {
            $describer->addPropertyTo($value, 'file', $rc->getFileName() . ':' . $rc->getStartLine());
        }
        $params = [];
        foreach ($rc->getParameters() as $param) {
            $params[] = '$' . $param->getName();
        }
        $value->value .= '(' . \implode(', ', $params) . ')';
        $uses = [];
        $useValue = new \RectorPrefix20210504\Tracy\Dumper\Value(\RectorPrefix20210504\Tracy\Dumper\Value::TYPE_OBJECT);
        $useValue->depth = $value->depth + 1;
        foreach ($rc->getStaticVariables() as $name => $v) {
            $uses[] = '$' . $name;
            $describer->addPropertyTo($useValue, '$' . $name, $v);
        }
        if ($uses) {
            $useValue->value = \implode(', ', $uses);
            $useValue->collapsed = \true;
            $value->items[] = ['use', $useValue];
        }
    }
    public static function exposeArrayObject(\ArrayObject $obj, \RectorPrefix20210504\Tracy\Dumper\Value $value, \RectorPrefix20210504\Tracy\Dumper\Describer $describer) : void
    {
        $flags = $obj->getFlags();
        $obj->setFlags(\ArrayObject::STD_PROP_LIST);
        self::exposeObject($obj, $value, $describer);
        $obj->setFlags($flags);
        $describer->addPropertyTo($value, 'storage', $obj->getArrayCopy(), \RectorPrefix20210504\Tracy\Dumper\Value::PROP_PRIVATE, null, \ArrayObject::class);
    }
    public static function exposeDOMNode(\DOMNode $obj, \RectorPrefix20210504\Tracy\Dumper\Value $value, \RectorPrefix20210504\Tracy\Dumper\Describer $describer) : void
    {
        $props = \preg_match_all('#^\\s*\\[([^\\]]+)\\] =>#m', \print_r($obj, \true), $tmp) ? $tmp[1] : [];
        \sort($props);
        foreach ($props as $p) {
            $describer->addPropertyTo($value, $p, $obj->{$p}, \RectorPrefix20210504\Tracy\Dumper\Value::PROP_PUBLIC);
        }
    }
    /**
     * @param  \DOMNodeList|\DOMNamedNodeMap  $obj
     */
    public static function exposeDOMNodeList($obj, \RectorPrefix20210504\Tracy\Dumper\Value $value, \RectorPrefix20210504\Tracy\Dumper\Describer $describer) : void
    {
        $describer->addPropertyTo($value, 'length', $obj->length, \RectorPrefix20210504\Tracy\Dumper\Value::PROP_PUBLIC);
        $describer->addPropertyTo($value, 'items', \iterator_to_array($obj));
    }
    public static function exposeSplFileInfo(\SplFileInfo $obj) : array
    {
        return ['path' => $obj->getPathname()];
    }
    public static function exposeSplObjectStorage(\SplObjectStorage $obj) : array
    {
        $res = [];
        foreach (clone $obj as $item) {
            $res[] = ['object' => $item, 'data' => $obj[$item]];
        }
        return $res;
    }
    public static function exposePhpIncompleteClass(\__PHP_Incomplete_Class $obj, \RectorPrefix20210504\Tracy\Dumper\Value $value, \RectorPrefix20210504\Tracy\Dumper\Describer $describer) : void
    {
        $values = (array) $obj;
        $class = $values['__PHP_Incomplete_Class_Name'];
        unset($values['__PHP_Incomplete_Class_Name']);
        foreach ($values as $k => $v) {
            $refId = $describer->getReferenceId($values, $k);
            if (isset($k[0]) && $k[0] === "\0") {
                $info = \explode("\0", $k);
                $k = \end($info);
                $type = $info[1] === '*' ? \RectorPrefix20210504\Tracy\Dumper\Value::PROP_PROTECTED : \RectorPrefix20210504\Tracy\Dumper\Value::PROP_PRIVATE;
                $decl = $type === \RectorPrefix20210504\Tracy\Dumper\Value::PROP_PRIVATE ? $info[1] : null;
            } else {
                $type = \RectorPrefix20210504\Tracy\Dumper\Value::PROP_PUBLIC;
                $k = (string) $k;
                $decl = null;
            }
            $describer->addPropertyTo($value, $k, $v, $type, $refId, $decl);
        }
        $value->value = $class . ' (Incomplete Class)';
    }
}
