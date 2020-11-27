<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Doctrine\Persistence;

use _PhpScoper26e51eeacccf\Doctrine\ORM\EntityManagerInterface;
if (\class_exists('_PhpScoper26e51eeacccf\\Doctrine\\Persistence\\ManagerRegistry')) {
    return;
}
final class ManagerRegistry
{
    public function getManager() : \_PhpScoper26e51eeacccf\Doctrine\Persistence\ObjectManager
    {
    }
}
