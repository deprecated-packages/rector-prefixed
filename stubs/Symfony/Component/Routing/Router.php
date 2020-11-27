<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Symfony\Component\Routing;

use _PhpScopera143bcca66cb\Symfony\Component\Routing\Generator\UrlGeneratorInterface;
if (\class_exists('_PhpScopera143bcca66cb\\Symfony\\Component\\Routing\\Router')) {
    return;
}
class Router implements \_PhpScopera143bcca66cb\Symfony\Component\Routing\RouterInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->getGenerator()->generate($name, $parameters, $referenceType);
    }
    private function getGenerator() : \_PhpScopera143bcca66cb\Symfony\Component\Routing\Generator\UrlGeneratorInterface
    {
    }
}
