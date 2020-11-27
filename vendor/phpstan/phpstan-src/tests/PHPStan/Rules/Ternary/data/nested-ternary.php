<?php

// lint < 8.0
namespace _PhpScopera143bcca66cb\NestedTernary;

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
