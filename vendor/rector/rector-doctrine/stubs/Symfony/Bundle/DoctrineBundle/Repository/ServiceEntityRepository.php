<?php

declare (strict_types=1);
namespace RectorPrefix20210322\Doctrine\Bundle\DoctrineBundle\Repository;

use RectorPrefix20210322\Doctrine\ORM\EntityRepository;
if (\class_exists('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository')) {
    return;
}
// @see https://github.com/doctrine/DoctrineBundle/blob/2.2.x/Repository/ServiceEntityRepository.php
abstract class ServiceEntityRepository extends \RectorPrefix20210322\Doctrine\ORM\EntityRepository
{
}
