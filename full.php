<?php
include('common.php');
$img_file = joinPath($base_folder, $QUERY['file']);

$content_type = mime_content_type($img_file);
header("Content-type: " . $content_type);

if(i($QUERY,'action') == 'download') header('Content-Disposition: attachment; filename="'.$QUERY['file'].'"'); // This will auto download the file.
else header('Content-Disposition: filename="'.$QUERY['file'].'"');

print file_get_contents($img_file);
