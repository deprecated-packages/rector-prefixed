<?php

declare (strict_types=1);
namespace RectorPrefix20210321\Symfony\Bundle\FrameworkBundle\Test;

if (\class_exists('Symfony\\Bundle\\FrameworkBundle\\Test\\WebTestCase')) {
    return;
}
class WebTestCase extends \RectorPrefix20210321\Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
}
