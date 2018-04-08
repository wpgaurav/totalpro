<?php
/**
 * Blog entry gallery format media
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 4.4.1
 *
 * @todo update to use new wpex_get_post_media_gallery_slider() function
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return standard thumbnail if gallery slider is disabled or shouldn't display
if ( apply_filters( 'wpex_disable_entry_slider', false )
	|| post_password_required()
	|| ! wpex_get_mod( 'blog_entry_gallery_output', true )
) {
	get_template_part( 'partials/blog/media/blog-entry' );
	return;
}

// Get current post id
$post_id = get_the_ID();

// Get attachments
$attachments = wpex_get_gallery_ids( $post_id );

// Display regular entry if there aren't any attachments
if ( empty( $attachments ) ) {
	get_template_part( 'partials/blog/media/blog-entry' );
	return;
}

// Get entry style
$entry_style = wpex_blog_entry_style();

// Slider data
$slider_data = wpex_get_post_slider_settings( array(
	'filter_tag' => 'wpex_blog_slider_data_atrributes',
) );

if ( 'grid-entry-style' === $entry_style ) {
	$slider_data['auto-height'] = 'false';
}

// Check if lightbox is enabled
$lightbox_enabled = false;
if ( wpex_gallery_is_lightbox_enabled( $post_id ) || wpex_get_mod( 'blog_entry_image_lightbox' ) ) {
	$lightbox_enabled = true;
	wpex_enqueue_ilightbox_skin();
} ?>

<div class="blog-entry-media entry-media clr">

	<div class="gallery-format-post-slider">

		<div class="wpex-slider-preloaderimg">
			<?php wpex_blog_entry_thumbnail( array(
				'attachment' => $attachments[0],
				'alt'        => get_post_meta( $attachments[0], '_wp_attachment_image_alt', true ),
			) ); ?>
		</div>

		<div class="wpex-slider slider-pro" <?php wpex_slider_data( $slider_data ); ?>>

			<div class="wpex-slider-slides sp-slides <?php if ( $lightbox_enabled ) echo 'lightbox-group'; ?>">

				<?php
				// Loop through attachments
				foreach ( $attachments as $attachment ) : ?>
					<?php
					// Get attachment data
					$attachment_data  = wpex_get_attachment_data( $attachment );
					$attachment_alt   = $attachment_data['alt'];
					$attachment_video = $attachment_data['video'];

					// Generate video
					if ( $attachment_video ) {
						$attachment_video = wpex_video_oembed( $attachment_video, 'sp-video', array(
							'youtube' => array(
								'enablejsapi' => '1',
							)
						) );
					}

					// Get image output
					$attachment_html = wpex_get_blog_entry_thumbnail( array(
						'attachment' => $attachment,
						'alt'        => $attachment_alt,
					) ); ?>

					<div class="wpex-slider-slide sp-slide">

						<?php
						// Display attachment video
						if ( $attachment_video ) : ?>

							<div class="wpex-slider-video responsive-video-wrap"><?php echo wpex_add_sp_video_to_oembed( $attachment_video ); ?></div>

						<?php
						// Display attachment image
						else : ?>

							<div class="wpex-slider-media clr">

								<?php
								// Display with lightbox
								if ( $lightbox_enabled ) :

									if ( apply_filters( 'wpex_blog_gallery_lightbox_title', false ) ) {
										$title_data_attr = ' data-title="'. esc_attr( $attachment_alt ) .'"';
									} else {
										$title_data_attr = ' data-show_title="false"';
									} ?>

									<a href="<?php echo wpex_get_lightbox_image( $attachment ); ?>" title="<?php echo esc_attr( $attachment_alt ); ?>" data-type="image" class="wpex-lightbox-group-item<?php wpex_entry_image_animation_classes(); ?>"<?php echo $title_data_attr; ?>><?php echo $attachment_html; ?></a>

								<?php
								// Display single image
								else : ?>

									<?php echo $attachment_html; ?>

									<?php
									// Display caption if defined
									if ( ! empty( $attachment_data['caption'] ) ) : ?>

										<div class="wpex-slider-caption sp-layer sp-black sp-padding clr" data-position="bottomCenter" data-show-transition="up" data-hide-transition="down" data-width="100%" data-show-delay="500">
											<?php echo wp_kses_post( $attachment_data['caption'] ); ?>
										</div><!-- .wpex-slider-caption -->

									<?php endif; ?>

								<?php endif; ?>

							</div><!-- .wpex-slider-media -->

						<?php endif; ?>

					</div><!-- .wpex-slider-slide sp-slide -->

				<?php endforeach; ?>

			</div><!-- .wpex-slider-slides .sp-slides -->

			<?php
			// Display nav thumbnails
			if ( 'large-image-entry-style' == $entry_style
				&& isset( $slider_data['thumbnails'] )
				&& 'true' == $slider_data['thumbnails']
			) : ?>

				<div class="wpex-slider-thumbnails sp-thumbnails">
					<?php
					// Loop through attachments
					foreach ( $attachments as $attachment ) : ?>
						<?php
						// Display image thumbnail
						wpex_blog_entry_thumbnail( array(
							'attachment' => $attachment,
							'class'      => 'wpex-slider-thumbnail sp-thumbnail',
							'alt'        => get_post_meta( $attachments, '_wp_attachment_image_alt', true ),
						) ); ?>
					<?php endforeach; ?>
				</div><!-- .wpex-slider-thumbnails -->

			<?php endif; ?>

		</div><!-- .wpex-slider .slider-pro -->

	</div><!-- .gallery-format-post-slider -->

</div><!-- .blog-entry-media -->