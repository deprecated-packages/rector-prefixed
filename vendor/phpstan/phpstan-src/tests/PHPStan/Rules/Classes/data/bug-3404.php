<?php

namespace _PhpScoper006a73f0e455\Bug3404;

new \finfo();
new \finfo(\FILEINFO_MIME_TYPE);
new \finfo(0, 'foo', 'bar');
