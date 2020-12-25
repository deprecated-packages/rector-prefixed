<?php

namespace Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture;

class SomeFormController extends \_PhpScoperbf340cb0be9d\Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function actionSomeForm(\_PhpScoperbf340cb0be9d\Symfony\Component\HttpFoundation\Request $request) : \_PhpScoperbf340cb0be9d\Symfony\Component\HttpFoundation\Response
    {
        $form = $this->createForm(\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture\SomeFormType::class);
        $form->handleRequest($request);
        if ($form->isSuccess() && $form->isValid()) {
        }
    }
}
