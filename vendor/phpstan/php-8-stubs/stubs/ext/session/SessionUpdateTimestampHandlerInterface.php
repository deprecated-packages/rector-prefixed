<?php

namespace _PhpScoper88fe6e0ad041;

interface SessionUpdateTimestampHandlerInterface
{
    /** @return bool */
    public function validateId(string $id);
    /** @return bool */
    public function updateTimestamp(string $id, string $data);
}
\class_alias('_PhpScoper88fe6e0ad041\\SessionUpdateTimestampHandlerInterface', 'SessionUpdateTimestampHandlerInterface', \false);
