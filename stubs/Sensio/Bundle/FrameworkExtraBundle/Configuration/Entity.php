<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Sensio\Bundle\FrameworkExtraBundle\Configuration;

if (\class_exists('_PhpScopera143bcca66cb\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Entity')) {
    return;
}
/**
 * @Annotation
 */
class Entity extends \_PhpScopera143bcca66cb\Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter
{
    public function setExpr($expr)
    {
        $options = $this->getOptions();
        $options['expr'] = $expr;
        $this->setOptions($options);
    }
}
