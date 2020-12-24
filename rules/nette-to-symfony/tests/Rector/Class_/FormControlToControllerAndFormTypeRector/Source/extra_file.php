<?php

namespace _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture;

class SomeFormController extends \_PhpScoper0a6b37af0871\Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function actionSomeForm(\_PhpScoper0a6b37af0871\Symfony\Component\HttpFoundation\Request $request) : \_PhpScoper0a6b37af0871\Symfony\Component\HttpFoundation\Response
    {
        $form = $this->createForm(\_PhpScoper0a6b37af0871\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture\SomeFormType::class);
        $form->handleRequest($request);
        if ($form->isSuccess() && $form->isValid()) {
        }
    }
}
