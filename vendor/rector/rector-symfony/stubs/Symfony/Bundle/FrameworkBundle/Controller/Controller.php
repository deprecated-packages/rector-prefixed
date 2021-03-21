<?php

declare (strict_types=1);
namespace RectorPrefix20210321\Symfony\Bundle\FrameworkBundle\Controller;

use RectorPrefix20210321\Symfony\Component\Form\FormInterface;
if (\class_exists('Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller')) {
    return;
}
class Controller
{
    public function createForm() : \RectorPrefix20210321\Symfony\Component\Form\FormInterface
    {
    }
}
