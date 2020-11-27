<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Sensio\Bundle\FrameworkExtraBundle\Configuration;

if (\class_exists('_PhpScoper006a73f0e455\\Sensio\\Bundle\\FrameworkExtraBundle\\Configuration\\Entity')) {
    return;
}
/**
 * @Annotation
 */
class Entity extends \_PhpScoper006a73f0e455\Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter
{
    public function setExpr($expr)
    {
        $options = $this->getOptions();
        $options['expr'] = $expr;
        $this->setOptions($options);
    }
}
