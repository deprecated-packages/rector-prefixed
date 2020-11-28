<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Symfony\Bundle\FrameworkBundle\Controller;

use _PhpScoperabd03f0baf05\Doctrine\Common\Persistence\ManagerRegistry;
use _PhpScoperabd03f0baf05\Symfony\Component\HttpFoundation\RedirectResponse;
use _PhpScoperabd03f0baf05\Symfony\Component\HttpFoundation\Response;
if (\class_exists('_PhpScoperabd03f0baf05\\Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController')) {
    return;
}
abstract class AbstractController
{
    public function getDoctrine() : \_PhpScoperabd03f0baf05\Doctrine\Common\Persistence\ManagerRegistry
    {
    }
    public function render($templateName, $params = []) : \_PhpScoperabd03f0baf05\Symfony\Component\HttpFoundation\Response
    {
    }
    public function redirectToRoute($routeName) : \_PhpScoperabd03f0baf05\Symfony\Component\HttpFoundation\RedirectResponse
    {
    }
}
