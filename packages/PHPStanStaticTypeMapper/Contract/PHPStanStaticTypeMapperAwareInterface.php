<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\Contract;

use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
interface PHPStanStaticTypeMapperAwareInterface
{
    /**
     * @return void
     */
    public function setPHPStanStaticTypeMapper(\Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper);
}
