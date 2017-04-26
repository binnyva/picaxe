<?php
require("./common.php");

$folder = get_absolute_path(i($QUERY, 'folder'));
$current_folder = realpath(joinPath($base_folder, $folder));

if(!$current_folder) {
	$QUERY['error'] = "Can't find the specified folder - <strong>" . joinPath($base_folder, $folder) . "</strong>";
	render('error.php');
	exit;
}

if(strstr($current_folder, $base_folder) === false) die("Its not that easy. Put in more effort! :-P"); // Slight hack attempt

$all_folders = ls('*', $current_folder, false, array('return_folders'));
$all_images = ls('*.{JPG,jpg,jpeg}', $current_folder, false, array('return_files'));

render();


function get_absolute_path($path) {
    $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
    $absolutes = array();
    foreach ($parts as $part) {
        if ('.' == $part) continue;
        if ('..' == $part) {
            array_pop($absolutes);
        } else {
            $absolutes[] = $part;
        }
    }
    return implode(DIRECTORY_SEPARATOR, $absolutes);
}