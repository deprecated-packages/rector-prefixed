<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Sensio\Bundle\FrameworkExtraBundle\Configuration;

if (\class_exists('_PhpScoper26e51eeacccf\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\ConfigurationAnnotation')) {
    return;
}
abstract class ConfigurationAnnotation
{
    public function __construct(array $values)
    {
        foreach ($values as $k => $v) {
            if (!\method_exists($this, $name = 'set' . $k)) {
                throw new \RuntimeException(\sprintf('Unknown key "%s" for annotation "@%s".', $k, \get_class($this)));
            }
            $this->{$name}($v);
        }
    }
}
