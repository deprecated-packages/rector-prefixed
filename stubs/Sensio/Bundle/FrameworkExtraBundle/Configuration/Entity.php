<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Sensio\Bundle\FrameworkExtraBundle\Configuration;

if (\class_exists('_PhpScoperbd5d0c5f7638\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Entity')) {
    return;
}
/**
 * @Annotation
 */
class Entity extends \_PhpScoperbd5d0c5f7638\Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter
{
    public function setExpr($expr)
    {
        $options = $this->getOptions();
        $options['expr'] = $expr;
        $this->setOptions($options);
    }
}
