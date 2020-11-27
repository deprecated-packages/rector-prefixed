<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Symfony\Bundle\FrameworkBundle\Controller;

use _PhpScoper88fe6e0ad041\Doctrine\Common\Persistence\ManagerRegistry;
use _PhpScoper88fe6e0ad041\Symfony\Component\HttpFoundation\RedirectResponse;
use _PhpScoper88fe6e0ad041\Symfony\Component\HttpFoundation\Response;
if (\class_exists('_PhpScoper88fe6e0ad041\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController')) {
    return;
}
abstract class AbstractController
{
    public function getDoctrine() : \_PhpScoper88fe6e0ad041\Doctrine\Common\Persistence\ManagerRegistry
    {
    }
    public function render($templateName, $params = []) : \_PhpScoper88fe6e0ad041\Symfony\Component\HttpFoundation\Response
    {
    }
    public function redirectToRoute($routeName) : \_PhpScoper88fe6e0ad041\Symfony\Component\HttpFoundation\RedirectResponse
    {
    }
}
