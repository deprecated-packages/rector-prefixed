<?php

namespace _PhpScoperb75b35f52b74\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture;

class SomeFormController extends \_PhpScoperb75b35f52b74\Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function actionSomeForm(\_PhpScoperb75b35f52b74\Symfony\Component\HttpFoundation\Request $request) : \_PhpScoperb75b35f52b74\Symfony\Component\HttpFoundation\Response
    {
        $form = $this->createForm(\_PhpScoperb75b35f52b74\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture\SomeFormType::class);
        $form->handleRequest($request);
        if ($form->isSuccess() && $form->isValid()) {
        }
    }
}
