<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Symfony\Bundle\FrameworkBundle\Controller;

use _PhpScoperbd5d0c5f7638\Doctrine\Common\Persistence\ManagerRegistry;
use _PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\RedirectResponse;
use _PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\Response;
if (\class_exists('_PhpScoperbd5d0c5f7638\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController')) {
    return;
}
abstract class AbstractController
{
    public function getDoctrine() : \_PhpScoperbd5d0c5f7638\Doctrine\Common\Persistence\ManagerRegistry
    {
    }
    public function render($templateName, $params = []) : \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\Response
    {
    }
    public function redirectToRoute($routeName) : \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\RedirectResponse
    {
    }
}
