<?php

namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture;

class SomeFormController extends \_PhpScoper2a4e7ab1ecbc\Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function actionSomeForm(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Request $request) : \_PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Response
    {
        $form = $this->createForm(\_PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture\SomeFormType::class);
        $form->handleRequest($request);
        if ($form->isSuccess() && $form->isValid()) {
        }
    }
}
