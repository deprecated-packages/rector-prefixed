<?php

namespace Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture;

class SomeFormController extends \_PhpScoper17db12703726\Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function actionSomeForm(\_PhpScoper17db12703726\Symfony\Component\HttpFoundation\Request $request) : \_PhpScoper17db12703726\Symfony\Component\HttpFoundation\Response
    {
        $form = $this->createForm(\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture\SomeFormType::class);
        $form->handleRequest($request);
        if ($form->isSuccess() && $form->isValid()) {
        }
    }
}
