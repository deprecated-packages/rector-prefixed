<?php

namespace _PhpScopere8e811afab72\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture;

class SomeFormController extends \_PhpScopere8e811afab72\Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function actionSomeForm(\_PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Request $request) : \_PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Response
    {
        $form = $this->createForm(\_PhpScopere8e811afab72\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture\SomeFormType::class);
        $form->handleRequest($request);
        if ($form->isSuccess() && $form->isValid()) {
        }
    }
}
