<?php

declare (strict_types=1);
namespace RectorPrefix20210320\Sensio\Bundle\FrameworkExtraBundle\Configuration;

if (\class_exists('RectorPrefix20210320\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Entity')) {
    return;
}
/**
 * @Annotation
 */
class Entity extends \RectorPrefix20210320\Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter
{
    public function setExpr($expr)
    {
        $options = $this->getOptions();
        $options['expr'] = $expr;
        $this->setOptions($options);
    }
}
