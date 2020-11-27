<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Symfony\Bundle\FrameworkBundle\Controller;

use _PhpScopera143bcca66cb\Doctrine\Common\Persistence\ManagerRegistry;
use _PhpScopera143bcca66cb\Symfony\Component\HttpFoundation\RedirectResponse;
use _PhpScopera143bcca66cb\Symfony\Component\HttpFoundation\Response;
if (\class_exists('_PhpScopera143bcca66cb\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController')) {
    return;
}
abstract class AbstractController
{
    public function getDoctrine() : \_PhpScopera143bcca66cb\Doctrine\Common\Persistence\ManagerRegistry
    {
    }
    public function render($templateName, $params = []) : \_PhpScopera143bcca66cb\Symfony\Component\HttpFoundation\Response
    {
    }
    public function redirectToRoute($routeName) : \_PhpScopera143bcca66cb\Symfony\Component\HttpFoundation\RedirectResponse
    {
    }
}
