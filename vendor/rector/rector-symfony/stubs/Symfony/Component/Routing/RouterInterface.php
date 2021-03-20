<?php

declare (strict_types=1);
namespace RectorPrefix20210320\Symfony\Component\Routing;

use RectorPrefix20210320\Symfony\Component\Routing\Generator\UrlGeneratorInterface;
if (\interface_exists('RectorPrefix20210320\\Symfony\\Component\\Routing\\RouterInterface')) {
    return;
}
interface RouterInterface extends \RectorPrefix20210320\Symfony\Component\Routing\Generator\UrlGeneratorInterface
{
}
