<?php

namespace _PhpScoperbd5d0c5f7638\Attributes;

#[\Attribute]
class IsAttribute
{
}
#[\Attribute(\Attribute::IS_REPEATABLE)]
class IsAttribute2
{
}
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_PROPERTY)]
class IsAttribute3
{
}
