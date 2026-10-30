<?php
$files = scandir('zips', SCANDIR_SORT_DESCENDING);
$newest_file = $files[0];

header('Content-Disposition: attachment; filename="'.$newest_file);
header('Content-Type: application/zip');
header('Content-Length: '.filesize('zips/'.$newest_file));
readfile('zips/'.$newest_file);

?>