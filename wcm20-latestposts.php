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
 * @param array $user_atts Attributes passed in shortcode
 * @param mixed $content Content inside shortcode
 * @param string $tag Shortcode tag (name). Default empty.
 * @return string
 */
function wlp_shortcode_latest_posts($user_atts = [], $content = null, $tag = '') {

	// change all attribute keys to lowercase
	$user_atts = array_change_key_case((array)$user_atts, CASE_LOWER);

	// set default values
	$default_atts = [
		'posts' => 3,
		'title' => __('Latest Posts', 'wcm20-latestposts'),
	];

	// combine default attributes with user attributes, and remove any unsupported keys
	$atts = shortcode_atts($default_atts, $user_atts, $tag);

	$output = "<h2>{$atts['title']}</h2>";

	$posts = new WP_Query([
		'posts_per_page' => $atts['posts'],
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
