<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		//
		// Post Content here
		//
		?>

		<?php
		echo sprintf("<h1><a href='%s'>%s</a></h1>", get_the_permalink(), get_the_title()); ?>
		<?php echo the_content(); ?>
<?php
	} // end while
} // end if
?>