<?php

declare (strict_types=1);
namespace RectorPrefix20210318\Symfony\Bundle\FrameworkBundle\Controller;

use RectorPrefix20210318\Doctrine\Common\Persistence\ManagerRegistry;
use RectorPrefix20210318\Symfony\Component\HttpFoundation\RedirectResponse;
use RectorPrefix20210318\Symfony\Component\HttpFoundation\Response;
if (\class_exists('RectorPrefix20210318\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController')) {
    return;
}
abstract class AbstractController
{
    public function getDoctrine() : \RectorPrefix20210318\Doctrine\Common\Persistence\ManagerRegistry
    {
    }
    public function render($templateName, $params = []) : \RectorPrefix20210318\Symfony\Component\HttpFoundation\Response
    {
    }
    public function redirectToRoute($routeName) : \RectorPrefix20210318\Symfony\Component\HttpFoundation\RedirectResponse
    {
    }
}
