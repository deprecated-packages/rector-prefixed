<?php

declare (strict_types=1);
namespace RectorPrefix20210319\Symfony\Component\Routing;

use RectorPrefix20210319\Symfony\Component\Routing\Generator\UrlGeneratorInterface;
if (\class_exists('RectorPrefix20210319\\Symfony\\Component\\Routing\\Router')) {
    return;
}
class Router implements \RectorPrefix20210319\Symfony\Component\Routing\RouterInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->getGenerator()->generate($name, $parameters, $referenceType);
    }
    private function getGenerator() : \RectorPrefix20210319\Symfony\Component\Routing\Generator\UrlGeneratorInterface
    {
    }
}
