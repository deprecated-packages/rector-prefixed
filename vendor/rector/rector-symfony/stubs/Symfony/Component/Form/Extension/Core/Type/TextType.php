<?php

declare (strict_types=1);
namespace RectorPrefix20210318\Symfony\Component\Form\Extension\Core\Type;

use RectorPrefix20210318\Symfony\Component\Form\FormBuilderInterface;
use RectorPrefix20210318\Symfony\Component\Form\FormTypeInterface;
if (\class_exists('RectorPrefix20210318\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType')) {
    return;
}
class TextType implements \RectorPrefix20210318\Symfony\Component\Form\FormTypeInterface, \RectorPrefix20210318\Symfony\Component\Form\FormBuilderInterface
{
}
