<?php

namespace _PhpScopera143bcca66cb;

interface SessionUpdateTimestampHandlerInterface
{
    /** @return bool */
    public function validateId(string $id);
    /** @return bool */
    public function updateTimestamp(string $id, string $data);
}
\class_alias('_PhpScopera143bcca66cb\\SessionUpdateTimestampHandlerInterface', 'SessionUpdateTimestampHandlerInterface', \false);
