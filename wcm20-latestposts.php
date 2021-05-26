<?php
/**
 * Plugin Name:	WCM20 Latest Posts
 * Description:	This plugin adds a shortcode to display the latest posts
 * Version:		0.1
 * Author:		Johan Nordström
 * Author URI:	https://www.thehiveresistance.com
 * Text Domain:	wcm20-latestposts
 * Domain Path:	/languages
 */

/**
 * Register plugin shortcodes
 */
function wlp_init() {
	// Register shortcode "latest-posts"
	add_shortcode('latest-posts', 'wlp_shortcode_latest_posts');
}
add_action('init', 'wlp_init');

/**
 * Shortcode [latest-posts]
 *
 * @param array $args Arguments passed in shortcode
 * @param mixed $content Content inside shortcode
 * @return string
 */
function wlp_shortcode_latest_posts($args = [], $content = null) {
	$output = "<h2>Latest Posts</h2>";

	$posts = new WP_Query([
		'posts_per_page' => 3,
	]);

	if ($posts->have_posts()) {
		$output .= "<ul>";

		// loop over available posts
		while ($posts->have_posts()) {
			$posts->the_post();

			$output .= "<li>";
			$output .= "<a href=\"" . get_the_permalink() . "\">";
			$output .= get_the_title();
			$output .= "</a>";
			$output .= "</li>";
		}

		// reset postdata
		wp_reset_postdata();

		$output .= "</ul>";

	} else {
		$output .= "<p><em>Sorry, no latest posts available.</em></p>";
	}

	return $output;
}
