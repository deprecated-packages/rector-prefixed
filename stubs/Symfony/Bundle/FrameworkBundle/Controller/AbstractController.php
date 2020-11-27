<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Symfony\Bundle\FrameworkBundle\Controller;

use _PhpScoper006a73f0e455\Doctrine\Common\Persistence\ManagerRegistry;
use _PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\RedirectResponse;
use _PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Response;
if (\class_exists('_PhpScoper006a73f0e455\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController')) {
    return;
}
abstract class AbstractController
{
    public function getDoctrine() : \_PhpScoper006a73f0e455\Doctrine\Common\Persistence\ManagerRegistry
    {
    }
    public function render($templateName, $params = []) : \_PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Response
    {
    }
    public function redirectToRoute($routeName) : \_PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\RedirectResponse
    {
    }
}
