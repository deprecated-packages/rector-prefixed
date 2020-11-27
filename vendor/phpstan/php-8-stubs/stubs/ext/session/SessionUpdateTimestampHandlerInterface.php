<?php

namespace _PhpScoperbd5d0c5f7638;

interface SessionUpdateTimestampHandlerInterface
{
    /** @return bool */
    public function validateId(string $id);
    /** @return bool */
    public function updateTimestamp(string $id, string $data);
}
\class_alias('_PhpScoperbd5d0c5f7638\\SessionUpdateTimestampHandlerInterface', 'SessionUpdateTimestampHandlerInterface', \false);
