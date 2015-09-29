<?php
include('common.php');
$img_file = joinPath($base_folder, $QUERY['file']);

$content_type = mime_content_type($img_file);
header("Content-type: " . $content_type);
print file_get_contents($img_file);
