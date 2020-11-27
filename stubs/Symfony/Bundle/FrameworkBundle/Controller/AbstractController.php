<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Symfony\Bundle\FrameworkBundle\Controller;

use _PhpScoper26e51eeacccf\Doctrine\Common\Persistence\ManagerRegistry;
use _PhpScoper26e51eeacccf\Symfony\Component\HttpFoundation\RedirectResponse;
use _PhpScoper26e51eeacccf\Symfony\Component\HttpFoundation\Response;
if (\class_exists('_PhpScoper26e51eeacccf\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController')) {
    return;
}
abstract class AbstractController
{
    public function getDoctrine() : \_PhpScoper26e51eeacccf\Doctrine\Common\Persistence\ManagerRegistry
    {
    }
    public function render($templateName, $params = []) : \_PhpScoper26e51eeacccf\Symfony\Component\HttpFoundation\Response
    {
    }
    public function redirectToRoute($routeName) : \_PhpScoper26e51eeacccf\Symfony\Component\HttpFoundation\RedirectResponse
    {
    }
}
