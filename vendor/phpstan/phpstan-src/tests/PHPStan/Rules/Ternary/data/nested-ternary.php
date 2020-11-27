<?php

// lint < 8.0
namespace _PhpScoper88fe6e0ad041\NestedTernary;

1 ? 2 : 3 ? 4 : 5;
// deprecated
1 ? 2 : 3 ? 4 : 5;
// ok
1 ? 2 : (3 ? 4 : 5);
// ok
1 ?: 2 ? 3 : 4;
// deprecated
1 ?: 2 ? 3 : 4;
// ok
1 ?: (2 ? 3 : 4);
// ok
1 ? 2 : 3 ?: 4;
// deprecated
1 ? 2 : 3 ?: 4;
// ok
1 ? 2 : (3 ?: 4);
// ok
1 ?: 2 ?: 3;
// ok
1 ?: 2 ?: 3;
// ok
1 ?: (2 ?: 3);
// ok
1 ? 2 ? 3 : 4 : 5;
// ok
1 ? 2 ?: 3 : 4;
// ok
