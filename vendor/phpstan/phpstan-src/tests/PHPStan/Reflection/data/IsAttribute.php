<?php

namespace _PhpScoper006a73f0e455\Attributes;

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
