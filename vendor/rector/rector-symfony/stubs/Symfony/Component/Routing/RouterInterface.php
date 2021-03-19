<?php

declare (strict_types=1);
namespace RectorPrefix20210319\Symfony\Component\Routing;

use RectorPrefix20210319\Symfony\Component\Routing\Generator\UrlGeneratorInterface;
if (\interface_exists('RectorPrefix20210319\\Symfony\\Component\\Routing\\RouterInterface')) {
    return;
}
interface RouterInterface extends \RectorPrefix20210319\Symfony\Component\Routing\Generator\UrlGeneratorInterface
{
}
