<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\Contract;

use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
interface PHPStanStaticTypeMapperAwareInterface
{
    /**
     * @return void
     * @param \Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper
     */
    public function setPHPStanStaticTypeMapper($phpStanStaticTypeMapper);
}
