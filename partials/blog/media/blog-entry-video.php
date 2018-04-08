<?php
/**
 * Blog entry video format media
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Display videos
if ( wpex_get_mod( 'blog_entry_video_output', true ) ) : ?>

	<?php
	// Get post video
	$video = wpex_get_post_video_html(); ?>

	<?php
	// Display video if one exists and it's not a password protected post
	if ( $video && ! post_password_required() ) : ?>

		<div class="blog-entry-media entry-media clr">
			<div class="blog-entry-video"><?php echo $video; ?></div>
		</div><!-- .blog-entry-media -->

	<?php
	// Else display post thumbnail
	else : ?>

		<?php get_template_part( 'partials/blog/media/blog-entry' ); ?>

	<?php endif; ?>

<?php
// Display thumbnail if video output is disabled
else : ?>

	<?php get_template_part( 'partials/blog/media/blog-entry' ); ?>

<?php endif; ?>