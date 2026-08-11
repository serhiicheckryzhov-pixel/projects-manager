<?php

$dir = '/var/www/html/storage/framework/views';
$temp = tempnam($dir, 'test');
echo "Temp file: $temp\n";
if (strpos($temp, $dir) === false) {
    echo "WARNING: Fallback to system temp directory!\n";
}
unlink($temp);
