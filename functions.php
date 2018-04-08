<?php
/**
 * Child theme functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Text Domain: wpex
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function total_child_enqueue_parent_theme_style() {

	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
	$theme   = wp_get_theme( 'Total' );
	$version = $theme->get( 'Version' );

	// Load the stylesheet
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css', array(), $version );
	
}
add_action( 'wp_enqueue_scripts', 'total_child_enqueue_parent_theme_style' );

// END ENQUEUE PARENT ACTION

function gt_wpex_typography_settings( $settings ) {
	$settings['blog_post_content'] = array(
		'label' => esc_html__( 'Blog Post Content', 'total' ),
		'target' => '.single-blog-article .entry',
		'transport' => 'refresh',
 	);
	return $settings;
}
add_filter( 'wpex_typography_settings', 'gt_wpex_typography_settings' );
// Change the page header style
add_filter( 'wpex_page_header_style', function( $style ) {

	// Change the page header style to "background-image" for all blog posts
	if ( is_singular( 'post' ) ) {
		$style = 'background-image';
	}

	// Return style
	return $style;

} );

// Change the page header background image
add_filter( 'wpex_page_header_background_image', function( $image ) {

	// Set a custom page header background image for all blog posts
	if ( is_singular('post')) {

		// Define your image url or ID => An attachment ID is always best
		$image = '20666';

		// You can use get_post_thumbnail_id() to use the post thumbnail) if you prefer like this
		if ( $thumbnail = get_post_thumbnail_id() ) {
			$image = $thumbnail;
		}

	}

	// Return image
	return $image;

} );

function gt_search_placeholder() {
	return __( 'Search anything', 'Total' );
}
add_filter( 'wpex_search_placeholder_text', 'gt_search_placeholder' );
// add_action( 'init', function() {
// 	remove_action( 'wp_head', 'wpex_theme_meta_generator', 1 );
// }, 10 );

function remove_styles_ok () {
    wp_deregister_style('jetpack-top-posts-widget');
	wp_deregister_style('wordpresscanvas-font-awesome');
	wp_deregister_style('sharedaddy');
	wp_deregister_style('social-logo');
	wp_deregister_style('jetpack-subscriptions');
// 	wp_deregister_style('wpex-ilightbox-light');
	wp_deregister_style('contact-form-7');
	wp_deregister_style('jetpack');
	wp_dequeue_style('jetpack-top-posts-widget');
	wp_dequeue_style('wordpresscanvas-font-awesome');
	wp_dequeue_style('sharedaddy');
	wp_dequeue_style('social-logo');
	wp_dequeue_style('jetpack-subscriptions');
// 	wp_dequeue_style('wpex-ilightbox-light');
	wp_dequeue_style('contact-form-7');
	wp_dequeue_style('jetpack');
	wp_deregister_style('menu-icons-extra');
	wp_dequeue_style('menu-icons-extra');
	wp_deregister_style('ionicons');
	wp_dequeue_style('ionicons');
	wp_deregister_style('elusiveicons');
	wp_dequeue_style('elusiveicons');
	wp_deregister_style('socicon');
	wp_dequeue_style('socicon');
	wp_deregister_style('budicon');
	wp_dequeue_style('budicon');
	wp_deregister_style('map-icons');
	wp_dequeue_style('map-icons');
	wp_deregister_style('themify-icons');
	wp_dequeue_style('themify-icons');
	wp_deregister_style('glyphicons-icons');
	wp_dequeue_style('glyphicons-icons');
	wp_dequeue_script( 'devicepx' );
	wp_dequeue_script( 'gmaps-js' );
		wp_deregister_script( 'devicepx' );
// 		wp_dequeue_script( 'jquery-migrate' );
// 		wp_deregister_script( 'jquery-migrate' );
	if (is_home() || is_front_page()) {
		wp_deregister_style('woocommerce-general');
		wp_deregister_style('wpfla-style-handle');
// 		wp_deregister_style('wpex-woocommerce-responsive');
// 		wp_dequeue_style('woocommerce-general');
		wp_dequeue_style('wpfla-style-handle');
		wp_dequeue_style('lets-review');
// 	    wp_deregister_style('elementor-icons');
// 		wp_deregister_style('elementor-animations');
// 		wp_deregister_style('elementor-pro');
// 		wp_dequeue_style('elementor-icons');
// 		wp_dequeue_style('wpex-woocommerce-responsive');
		wp_dequeue_style('lets-review');
		wp_dequeue_script('wc-cart-fragments');
	}
	
}
add_action ('wp_print_styles', 'remove_styles_ok');
add_action( 'wpex_hook_page_header_inner', function() {

	// Only add on blog posts
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	
	get_template_part( 'partials/breadcrumbs' );
}, 40 );
add_filter( 'wpex_blog_single_layout_blocks', function( $blocks ) {

	$blocks['last_updated'] = function() {

		$original_time = get_the_time( 'U' ); 
		$modified_time = get_the_modified_time( 'U' );

		if ( $modified_time >= $original_time + 86400 ) {
			$updated_day = get_the_modified_time( 'F jS, Y' );

			echo '<div class="last-modified"><i class="fa fa-upload"></i> Updated: ' . $updated_day .  '</div>';

		}

	};

	return $blocks;

} );

add_filter( 'wpex_blog_single_blocks', function( $blocks ) {
	$blocks['last_updated'] = __( 'Last Updated', 'total' );
	return $blocks;
} );

// Headings ID

// function auto_id_headings( $content ) {
// 	$content = preg_replace_callback( '/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function( $matches ) {
// 		if ( ! stripos( $matches[0], 'id=' ) ) :
// 			$heading_link = '<a href="#' . sanitize_title( $matches[3] ) . '" class="heading-link"><i class="fa fa-link"></i></a>';
// 			$matches[0] = $matches[1] . $matches[2] . ' id="' . sanitize_title( $matches[3] ) . '">' . $heading_link . $matches[3] . $matches[4];
// 		endif;
// 		return $matches[0];
// 	}, $content );
//     return $content;
// }
// add_filter( 'the_content', 'auto_id_headings' );

/**
 * Alter your post layouts
 *
 * @return full-width, full-screen, left-sidebar or right-sidebar
 *
 */

/**
 * Change Post Series Archive Entry Style
 * Available options: large-image-entry-style, thumbnail-entry-style, grid-entry-style
 */
// function my_post_series_entry_style( $style ) {
// 	if ( is_tax( 'post_series' ) ) return 'large-image-entry-style';
// 	return $style;
// }
// add_filter( 'wpex_blog_style', 'my_post_series_entry_style' );
// add_filter( 'wpex_blog_entry_style', 'my_post_series_entry_style' );
function wpex_remove_script_version( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'script_loader_src', 'wpex_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'wpex_remove_script_version', 15, 1 );
// function myprefix_google_fonts( $array ) {
//     return array( 'Hind', 'Open Sans', 'Source Sans Pro', 'Merriweather' );
// }
// add_filter( 'wpex_google_fonts_array', 'myprefix_google_fonts' );
add_filter('woocommerce_get_price_html', 'changeFreePriceNotice', 10, 2);
 
function changeFreePriceNotice($price, $product) {
	if ( $price == wc_price( 0.00 ) )
		return 'Free';
	else
		return $price;
}
add_filter( 'wpex_localize_array', function( $array ) {
	$array['sidrDropdownTarget'] = 'li';
	return $array;
} );
add_filter( 'wpex_blog_post_related_query_args', function ( $args ) {
	
	// Get first category
	$cats = wp_get_post_terms( get_the_ID(), 'category' );

	// Get from 1st category only
	$cats['category__in'] = array( $cats[0]->term_id );

	// Return args
	return $args; 

} );
add_filter( 'wpex_tiny_mce_formats_items', function( $items ) {
// 	Five items 0-4 already exist - not pushing those
	$items[5] = array(
		'title'   => esc_html__( 'Author Speaks', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'author-speaks', // The class that is added for styling
	);
	$items[6] = array(
		'title'   => esc_html__( 'Intro', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'intro', // The class that is added for styling
	);
	$items[7] = array(
		'title'   => esc_html__( 'Pull Right', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'pull-right', // The class that is added for styling
	);
	$items[8] = array(
		'title'   => esc_html__( 'Pull Left', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'pull-left', // The class that is added for styling
	);
	$items[9] = array(
		'title'   => esc_html__( 'Customized heading', 'total' ),
		'selector'  => 'h3', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'centered-heading', // The class that is added for styling
	);
	$items[10] = array(
		'title'   => esc_html__( 'Para after centered heading', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'after-centered-heading', // The class that is added for styling
	);
	$items[11] = array(
		'title'   => esc_html__( 'Customized Heading Two', 'total' ),
		'selector'  => 'h3', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'centered-heading-2', // The class that is added for styling
	);
	$items[12] = array(
		'title'   => esc_html__( 'Para after Customized heading Two', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'after-centered-heading-2', // The class that is added for styling
	);
	$items[13] = array(
		'title'   => esc_html__( 'Button Icon', 'total' ),
		'inline'  => 'i', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'fa fa-book', // The class that is added for styling
	);
	$items[14] = array(
		'title'   => esc_html__( 'Dark Block', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'blocks dark-block', // The class that is added for styling
	);
	$items[15] = array(
		'title'   => esc_html__( 'Gradient Block', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'blocks gradient-alt', // The class that is added for styling
	);
	$items[16] = array(
		'title'   => esc_html__( 'Light Block', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'blocks light-block', // The class that is added for styling
	);
	$items[17] = array(
		'title'   => esc_html__( 'Half Block', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'blocks vc_col-sm-6', // The class that is added for styling
	);
	$items[18] = array(
		'title'   => esc_html__( 'One Third Block', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'blocks vc_col-sm-4', // The class that is added for styling
	);
	$items[19] = array(
		'title'   => esc_html__( 'Warning', 'total' ),
		'selector'  => 'p', // Tag to be added to item (div, p, a, span, ul)
		'classes' => 'callout callout-warning', // The class that is added for styling
	);
	return $items;
} );
function myprefix_entry_single_meta_sections( $sections ) {
	$sections['post_view_section'] = function() {
		$icon = '<span class="fa fa-eye"></span>';
		echo  $icon . do_shortcode( '[post_view]' );
	};
	return $sections;
}
// add_filter( 'wpex_blog_entry_meta_sections', 'myprefix_entry_single_meta_sections' );
add_filter( 'wpex_blog_single_meta_sections', 'myprefix_entry_single_meta_sections' );
function jeherve_add_cpt_sitemaps( $post_types ) {
    $post_types[] = array('portfolio', 'product', 'microblog');
    return $post_types;
}
add_filter( 'jetpack_sitemap_post_types', 'jeherve_add_cpt_sitemaps' );
function myprefix_add_cpts_to_blog( $query ) {
	if ( ! is_admin()
		&& $query->is_main_query()
		&& $query->is_home()
	) {
		$query->set( 'post_type', array( 'post', 'microblog' ) );
	}
}
add_action( 'pre_get_posts', 'myprefix_add_cpts_to_blog' );
// Change Post Series Archive Layout
function my_alter_post_series_layout( $layout ) {
   if ( is_tax( 'post_series' ) ) {
        return 'full-width';
    }
    return $layout;
}
add_filter( 'wpex_post_layout_class', 'my_alter_post_series_layout' );
add_filter( 'wpex_google_fonts_array', function( $array ) {
    $array[0] = 'Barlow';
	$array[1] = 'Nunito Sans';
	$array[2] = 'Zilla Slab';
	$array[3] = 'Rubik';
    return $array;
} );

// Add new widget area "toggle_sidebar"
add_action( 'widgets_init', function() {
	register_sidebar( array(
		'name'          => 'Toggle Sidebar',
		'id'            => 'mobile_menu_sidr_widgets',
		'before_widget' => '<div id="%1$s" class="sidebar-box widget %2$s clr">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-title">',
		'after_title'   => '</div>',
	) );
}, 10 ); // Change the 10 priority to move it up/down on the widgets list

// If the "mobile_menu_sidr_widgets" widget area has widgets insert the widgets
// as html to the bottom of the site and hidden so they can be rendered
// inside the sidebar mobile menu via the theme's javascript
add_action( 'wp_footer', function() { 
	if ( ! is_active_sidebar( 'mobile_menu_sidr_widgets' ) ) {
		return;
	}
	echo '<div id="mobile-sidebar-widget-area" class="clr" style="display:none;">';
		dynamic_sidebar( 'mobile_menu_sidr_widgets' );
	echo '</div>';
} );

// If the "toggle_sidebar" widget area has widgets add it to the list of
// elements to grab for the mobile sidebar menu
add_filter( 'wpex_mobile_menu_source', function ( $source ) {
	if ( is_active_sidebar( 'mobile_menu_sidr_widgets' ) ) {
		$source['mobile-sidebar-widget-area'] = '#mobile-sidebar-widget-area';
	}
	return $source;
} );
// function custom_text_editor_styles() {
// 	wp_enqueue_style('editor-styles','/wp-content/themes/totalpro/editor-style.css');
// }
// add_action('admin_enqueue_scripts', 'custom_text_editor_styles');
// add_action('login_enqueue_scripts', 'custom_text_editor_styles');
	
function gt_mce_css( $mce_css ) {
	if ( ! empty( $mce_css ) )
                $mce_css .= ',';
	$mce_css .= '/wp-content/themes/totalpro/gt-editor-style.css';
	return $mce_css;
}
add_filter( 'mce_css', 'gt_mce_css' );
add_filter( 'wpex_register_sidebars_array', function( $sidebars ) {
	$sidebars['bottom_sidebar'] = __( 'Single Bottom', 'total' );
	return $sidebars;
} );
add_filter( 'wpex_blog_single_blocks', function( $blocks ) {

    // Add new block "advertisement"
    $blocks['bottom'] = __( 'Bottom Widgets', 'total' );

    // Return blocks
    return $blocks;

} );
// Add a filter for the post thumbnail ID since it doesn't exist in WP core
add_filter( 'get_post_metadata', function ( $value, $post_id, $meta_key, $single ) {
	
	// We want to pass the actual _thumbnail_id into the filter, so requires recursion
	static $is_recursing = false;
	
	// Only filter if we're not recursing and if it is a post thumbnail ID
	if ( ! $is_recursing && $meta_key === '_thumbnail_id' ) {
		$is_recursing = true; // prevent this conditional when get_post_thumbnail_id() is called
		$value = get_post_thumbnail_id( $post_id );
		$is_recursing = false;
		$value = apply_filters( 'post_thumbnail_id', $value, $post_id ); // yay!
		if ( ! $single ) {
			$value = array( $value );
		}
	}
	
	return $value;

}, 10, 4);

// Add fallback for post thumbnail
// So whenever a featured image is called if there isn't one for the current post it will return
// your fallback attachment
add_filter( 'post_thumbnail_id', function( $id ) {
	return $id ? $id : 25292; // Set fallback to attachment with ID of 5
} );
function fixed_widget_hook() { ?>
    <div id="fixed-widget-kill"></div>
<?php }
add_action( 'wpex_hook_content_after', 'fixed_widget_hook', 999 );
function analytics_hook() { ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-44330336-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-44330336-1');
</script>
<?php }
add_action( 'wp_head', 'analytics_hook', 999 );
function notification_hooks() { ?>
<?php 
$notices = array(
	"<div class='alertone'>
  <span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span> Starting April 8, 2018 - we are switching to Google Analytics. <a class='button button-green' href='/privacy-policy/'>Privacy Policy</a>
</div>", "<div class='alertwo'>
  <span class='closebtn' onclick=this.parentElement.style.display='none';>&times;</span> Starting April 8, 2018 - we are switching to Analytics. <a class='button button-green' href='/privacy-policy/'>Privacy Policy</a>
</div>"
);
echo $notices[rand(0, count($notices) - 1)];
 ?>
<?php }
add_action( 'wpex_outer_wrap_before', 'notification_hooks', 999 );