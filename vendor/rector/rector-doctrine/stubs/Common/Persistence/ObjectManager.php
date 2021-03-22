<?php

declare (strict_types=1);
namespace RectorPrefix20210322\Doctrine\Common\Persistence;

if (\interface_exists('Doctrine\\Common\\Persistence\\ObjectManager')) {
    return;
}
interface ObjectManager
{
    public function getRepository() : \RectorPrefix20210322\Doctrine\ORM\EntityRepository;
}
