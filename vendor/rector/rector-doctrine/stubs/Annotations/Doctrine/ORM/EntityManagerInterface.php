<?php

declare (strict_types=1);
namespace RectorPrefix20210322\Doctrine\ORM;

use RectorPrefix20210322\Doctrine\Common\Persistence\ObjectManager;
if (\interface_exists('Doctrine\\ORM\\EntityManagerInterface')) {
    return;
}
interface EntityManagerInterface extends \RectorPrefix20210322\Doctrine\Common\Persistence\ObjectManager
{
}
