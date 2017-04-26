<br /><br />
<?php if($current_folder != $base_folder) { ?><div class="folder with-icon"><a href="index.php?folder=<?php echo joinPath($folder, '..') ?>">Parent..</a></div><?php  } ?>
<?php foreach($all_folders as $f) {
	if($f == 'Private/' or $f == 'Ahem/') continue; // Don't show these folders.
?>
<div class="folder with-icon"><a href="index.php?folder=<?php echo joinPath($folder, $f) ?>"><?php echo $f ?></a></div>
<?php  } ?>

<div class="my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
<?php 
$max_width = 1024;
$max_height = 768;

$image_size_cache_file = joinPath($config['site_folder'], 'cache', md5(joinPath($base_folder, $folder)) . ".json");
if(file_exists($image_size_cache_file)) $image_sizes = json_decode(file_get_contents($image_size_cache_file), true);
// dump($image_sizes);

foreach($all_images as $f) {
	if(!isset($image_sizes[$f])) {
		$image_sizes[$f] = array(
				'rotate' => false,
				'height' => 0,
				'width'	 => 0
			);

		$img = new Image(joinPath($base_folder, $folder, $f));
		$ratio = $img->get('width') / $img->get('height');

		$width = $img->get('width');
		if($width > $max_width) $width = $max_width;
		$height = intval($width / $ratio);

		$image_sizes[$f]['rotate'] = false;
		if(function_exists('exif_read_data')) {
			$exif = exif_read_data(joinPath($base_folder, $folder, $f), 0, true);

			if($exif and isset($exif['IFD0']['Orientation'])) {
				if($exif['IFD0']['Orientation'] == 8) {
					// $swap = $height;
					// $height = $width;
					// $width = $swap;
					$image_sizes[$f]['rotate'] = true;
				}
			}
		}

		// $size = $width . "x" . $height;
		$image_sizes[$f]['width'] = $width;
		$image_sizes[$f]['height'] = $height;

		// dump($ratio, $width, $height, joinPath($base_folder, $folder, $f));exit;
		@$img->destroy();
	}
	?>
<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
    <a href="full.php?file=<?php echo joinPath($folder, $f) ?>" itemprop="contentUrl" 
    		data-size="<?php echo $image_sizes[$f]['width'] .'x' . $image_sizes[$f]['height'] ?>" data-rotate="<?php echo $image_sizes[$f]['rotate'] ?>">
        <img src="thumb.php?file=<?php echo joinPath($folder, $f) ?>" itemprop="thumbnail" alt="<?php echo $f ?>" />
    </a><br />
    <figcaption itemprop="caption description"><?php echo "$f" ?></figcaption>
</figure>
<!-- <div class="img"><a href="full.php?file=<?php echo joinPath($folder, $f) ?>"><img src="thumb.php?file=<?php echo joinPath($folder, $f) ?>" /></a></div> -->
<?php  } ?>
</div>

<?php
// Save the size cache....
if(!file_exists($image_size_cache_file)) file_put_contents($image_size_cache_file, json_encode($image_sizes));
