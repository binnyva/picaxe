<br /><br />
<?php if($current_folder != $base_folder) { ?><div class="folder with-icon"><a href="index.php?folder=<?php echo joinPath($folder, '..') ?>">Parent..</a></div><?php  } ?>
<?php foreach($all_folders as $f) {
	if($f == 'Private/' or $f == 'Ahem/') continue; // Don't show these folders.
?>
<div class="folder with-icon"><a href="index.php?folder=<?php echo joinPath($folder, $f) ?>"><?php echo $f ?></a></div>
<?php  } ?>

<?php foreach($all_images as $f) { ?>
<div class="img"><a href="full.php?file=<?php echo joinPath($folder, $f) ?>"><img src="thumb.php?file=<?php echo joinPath($folder, $f) ?>" /></a></div>
<?php  } ?>

