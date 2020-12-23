<?php

namespace _PhpScoper0a2ac50786fa\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture;

class SomeFormController extends \_PhpScoper0a2ac50786fa\Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function actionSomeForm(\_PhpScoper0a2ac50786fa\Symfony\Component\HttpFoundation\Request $request) : \_PhpScoper0a2ac50786fa\Symfony\Component\HttpFoundation\Response
    {
        $form = $this->createForm(\_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture\SomeFormType::class);
        $form->handleRequest($request);
        if ($form->isSuccess() && $form->isValid()) {
        }
    }
}
