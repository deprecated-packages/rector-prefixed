<?php

declare (strict_types=1);
namespace RectorPrefix20210319\Symfony\Bundle\FrameworkBundle\Test;

if (\class_exists('RectorPrefix20210319\\Symfony\\Bundle\\FrameworkBundle\\Test\\WebTestCase')) {
    return;
}
class WebTestCase extends \RectorPrefix20210319\Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
}
