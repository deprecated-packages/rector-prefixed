<?php

namespace Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture;

class SomeFormController extends \RectorPrefix20201229\Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function actionSomeForm(\RectorPrefix20201229\Symfony\Component\HttpFoundation\Request $request) : \RectorPrefix20201229\Symfony\Component\HttpFoundation\Response
    {
        $form = $this->createForm(\Rector\NetteToSymfony\Tests\Rector\Class_\FormControlToControllerAndFormTypeRector\Fixture\SomeFormType::class);
        $form->handleRequest($request);
        if ($form->isSuccess() && $form->isValid()) {
        }
    }
}
