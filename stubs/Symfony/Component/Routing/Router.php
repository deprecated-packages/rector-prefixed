<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Symfony\Component\Routing;

use _PhpScoper88fe6e0ad041\Symfony\Component\Routing\Generator\UrlGeneratorInterface;
if (\class_exists('_PhpScoper88fe6e0ad041\\Symfony\\Component\\Routing\\Router')) {
    return;
}
class Router implements \_PhpScoper88fe6e0ad041\Symfony\Component\Routing\RouterInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->getGenerator()->generate($name, $parameters, $referenceType);
    }
    private function getGenerator() : \_PhpScoper88fe6e0ad041\Symfony\Component\Routing\Generator\UrlGeneratorInterface
    {
    }
}
