<?php
include('common.php');
$img_file = joinPath($base_folder, $QUERY['file']);

$md5 = md5($img_file);
$ext = pathinfo($img_file, PATHINFO_EXTENSION);
$cache_file = joinPath($config['site_folder'], 'cache', $md5 . '.' . $ext);

if(file_exists($cache_file)) {
	$content_type = mime_content_type($cache_file);
	header("Content-type: " . $content_type);
	print file_get_contents($cache_file);

} else {
	// print "File '$img_file' not found.";
	// dump($img_file);
	$img = new Image($img_file);
	$img->resize(200,0,false);
	$img->save($cache_file);
	$img->show();
	// dump($img);
}