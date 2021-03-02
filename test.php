<?php
file_put_contents('./test.txt', date('Y-m-d H:i:s', time()) . PHP_EOL, FILE_APPEND);
