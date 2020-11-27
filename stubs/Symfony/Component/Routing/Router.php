<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Symfony\Component\Routing;

use _PhpScoperbd5d0c5f7638\Symfony\Component\Routing\Generator\UrlGeneratorInterface;
if (\class_exists('_PhpScoperbd5d0c5f7638\\Symfony\\Component\\Routing\\Router')) {
    return;
}
class Router implements \_PhpScoperbd5d0c5f7638\Symfony\Component\Routing\RouterInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->getGenerator()->generate($name, $parameters, $referenceType);
    }
    private function getGenerator() : \_PhpScoperbd5d0c5f7638\Symfony\Component\Routing\Generator\UrlGeneratorInterface
    {
    }
}
