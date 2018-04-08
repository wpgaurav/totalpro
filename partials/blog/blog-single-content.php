<?php
/**
 * Single blog post content
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<script data-cfasync="false" type='text/x-mathjax-config'>
MathJax.Hub.Config({ messageStyle: "none", TeX: { equationNumbers: { autoNumber: "AMS" }, extensions: ["autobold.js"] }, tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}, processEscapes: true, menuSettings: { zoom: "Double-Click" }});</script>

<script data-cfasync="false" type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

<div class="single-blog-content entry clr"<?php wpex_schema_markup( 'entry_content' ); ?>><?php the_content(); ?></div>

<?php
// Page links (for the <!-nextpage-> tag)
get_template_part( 'partials/link-pages' ); ?>