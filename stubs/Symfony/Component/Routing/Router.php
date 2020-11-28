<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Symfony\Component\Routing;

use _PhpScoperabd03f0baf05\Symfony\Component\Routing\Generator\UrlGeneratorInterface;
if (\class_exists('_PhpScoperabd03f0baf05\\Symfony\\Component\\Routing\\Router')) {
    return;
}
class Router implements \_PhpScoperabd03f0baf05\Symfony\Component\Routing\RouterInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->getGenerator()->generate($name, $parameters, $referenceType);
    }
    private function getGenerator() : \_PhpScoperabd03f0baf05\Symfony\Component\Routing\Generator\UrlGeneratorInterface
    {
    }
}
