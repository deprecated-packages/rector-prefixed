<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Sensio\Bundle\FrameworkExtraBundle\Configuration;

if (\class_exists('_PhpScoperabd03f0baf05\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Entity')) {
    return;
}
/**
 * @Annotation
 */
class Entity extends \_PhpScoperabd03f0baf05\Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter
{
    public function setExpr($expr)
    {
        $options = $this->getOptions();
        $options['expr'] = $expr;
        $this->setOptions($options);
    }
}
