<?php
/**
 * Single blog post layout
 *
 * All blog elements can be re-ordered via the WP Customizer or filtered via theme
 * filters so do NOT edit this file manually or via a child theme.
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 4.4.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Custom template design
if ( $template_content = wpex_get_singular_template_content( 'post' ) ) {
	echo '<div class="custom-singular-template wpex-clr">' . apply_filters( 'the_content', $template_content ) . '</div>';
	return;
} ?>
<!-- <style>
  @import url("https://use.typekit.net/uzb7pwh.css");
</style> -->
<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->

<article id="single-blocks" class="single-blog-article clr"<?php wpex_schema_markup( 'blog_post' ); ?>>

	<?php
	// Get post format
	$post_format = get_post_format();

	// Quote format is completely different
	if ( 'quote' == $post_format ) :

		wpex_get_template_part( 'blog_single_quote' );

		return;

	// Blog Single Post Composer
	else :

		// Get layout blocks
		$blocks = wpex_blog_single_layout_blocks();

		// Make sure we have blocks and it's an array
		if ( ! empty( $blocks ) && is_array( $blocks ) ) :

			// Loop through blocks
			foreach ( $blocks as $block ) :

				// Callable output
				if ( 'the_content' != $block && is_callable( $block ) ) {

					call_user_func( $block );

				}

				// Post title
				elseif ( 'title' == $block ) {

					wpex_get_template_part( 'blog_single_title' );

				}

				// Post meta
				elseif ( 'meta' == $block ) {

					wpex_get_template_part( 'blog_single_meta' );

				}

				// Featured Media - featured image, video, gallery, etc
				elseif ( 'featured_media' == $block ) {

					if ( wpex_get_custom_post_media_position() ) {
						continue;
					}
						
					wpex_get_template_part( 'blog_single_media', $post_format );
					
				}

				// Post Series
				elseif ( 'post_series' == $block ) {
					
					wpex_get_template_part( 'post_series' );

				}

				// Get post content
				elseif ( 'the_content' == $block ) {

					wpex_get_template_part( 'blog_single_content' );

				}

				// Post Tags
				elseif ( 'post_tags' == $block ) {

					wpex_get_template_part( 'blog_single_tags' );

				}

				// Social sharing links
				elseif ( 'social_share' == $block ) {

					wpex_social_share();
				  
				}

				// Author bio
				elseif ( 'author_bio' == $block && 'hide' != get_post_meta( get_the_ID(), 'wpex_post_author', true ) ) {

					wpex_get_template_part( 'author_bio' );

				}

				// Displays related posts
				elseif ( 'related_posts' == $block ) {

					wpex_get_template_part( 'blog_single_related' );

				}

				// Get the post comments & comment_form
				elseif ( 'comments' == $block ) {

					comments_template();

				}

				// Custom Blocks
				else {

					get_template_part( 'partials/blog/blog-single', $block );

				}

			endforeach;

		endif;

	endif; ?>

</article><!-- #single-blocks -->