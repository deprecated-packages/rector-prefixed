<?php

declare (strict_types=1);
namespace RectorPrefix20210318\Symfony\Component\HttpFoundation;

if (\class_exists('RectorPrefix20210318\\Symfony\\Component\\HttpFoundation\\RedirectResponse')) {
    return;
}
final class RedirectResponse extends \RectorPrefix20210318\Symfony\Component\HttpFoundation\Response
{
}
