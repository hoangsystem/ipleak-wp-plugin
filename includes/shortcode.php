<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function ipleak_wp_register_shortcode() {
	add_shortcode( 'ipleak_info', 'ipleak_wp_render_info_block' );
}
add_action( 'init', 'ipleak_wp_register_shortcode' );

function ipleak_wp_render_info_block() {
	ob_start(); ?>
	<div id="ipleak-wp-wrapper" class="ipleak-wp-block wp-block">
		<h2 class="ipleak-wp-heading"><?php esc_html_e( 'Privacy Check Results', 'ipleak-wp-plugin' ); ?></h2>
		<div class="ipleak-wp-results"></div>
		<button class="ipleak-wp-recheck-button" type="button"><?php esc_html_e( 'Check Again', 'ipleak-wp-plugin' ); ?></button>
	</div>
	<?php return ob_get_clean();
}
