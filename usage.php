<?php
$ret = shell_exec('htop 2>&1;');
echo '<pre>';
print($ret);