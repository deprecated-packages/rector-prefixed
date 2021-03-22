<?php

declare (strict_types=1);
namespace RectorPrefix20210322\Doctrine\Common\Persistence;

use RectorPrefix20210322\Doctrine\ORM\EntityManagerInterface;
if (\class_exists('Doctrine\\Common\\Persistence\\ManagerRegistry')) {
    return;
}
final class ManagerRegistry
{
    public function getManager() : \RectorPrefix20210322\Doctrine\Common\Persistence\ObjectManager
    {
    }
}
