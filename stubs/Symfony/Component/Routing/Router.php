<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Symfony\Component\Routing;

use _PhpScoper006a73f0e455\Symfony\Component\Routing\Generator\UrlGeneratorInterface;
if (\class_exists('_PhpScoper006a73f0e455\\Symfony\\Component\\Routing\\Router')) {
    return;
}
class Router implements \_PhpScoper006a73f0e455\Symfony\Component\Routing\RouterInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->getGenerator()->generate($name, $parameters, $referenceType);
    }
    private function getGenerator() : \_PhpScoper006a73f0e455\Symfony\Component\Routing\Generator\UrlGeneratorInterface
    {
    }
}
