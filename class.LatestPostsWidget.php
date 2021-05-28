<?php

class LatestPostsWidget extends WP_Widget {

	/**
	 * Construct a new widget instance.
	 */
	public function __construct() {
		parent::__construct(
			'wcm20-latestposts-widget', // Base ID
			'Latest Posts', // Name
			[
				'description' => 'Example widget for displaying the latest posts.',
			]
		);
	}

	/**
	 * Front-end display of the widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved option values for this specific instance of the widget.
	 * @return void
	 */
	public function widget($args, $instance) {
		// start widget
		echo $args['before_widget'];

		// render title
		if (!empty($instance['title'])) {
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		}

		// get latest posts
		$posts = new WP_Query([
			'posts_per_page' => 3,
		]);

		if ($posts->have_posts()) {
			$output = '<ul class="latest-posts-list">';

			// loop over available posts
			while ($posts->have_posts()) {
				$posts->the_post();

				$output .= sprintf(
					'<li class="latest-post-list-item"><a href="%s">%s</a> <small>in %s by %s %s ago</small></li>',
					get_the_permalink(),
					get_the_title(),
					get_the_category_list(', '),
					get_the_author(),
					human_time_diff(get_the_date('U'), current_time('timestamp'))
				);
			}

			// reset postdata
			wp_reset_postdata();

			$output .= "</ul>";

		} else {
			$output = "<p><em>Sorry, no latest posts available.</em></p>";
		}

		// output latest posts
		echo $output;

		// end widget
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Current saved values for this instance of the widget.
	 * @return void
	 */
	public function form($instance) {

		// do we have a title set? if so, use it, otherwise set empty title
		$title = isset($instance['title']) ? $instance['title'] : '';

		?>
			<!-- title -->
			<p>
				<label for="<?php echo $this->get_field_id('title') ?>">Title:</label>

				<input
					class="widefat"
					id="<?php echo $this->get_field_id('title') ?>"
					name="<?php echo $this->get_field_name('title') ?>"
					type="text"
					value="<?php echo $title; ?>"
				>
			</p>
		<?php
	}

	/**
	 * Sanitize widget form data before they are saved to the database.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Form values just sent to be saved.
	 * @param array $old_instance Currently saved values.
	 * @return void
	 */
	public function update($new_instance, $old_instance) {
		$instance = [];

		$instance['title'] = (!empty($new_instance['title']))
			? strip_tags($new_instance['title'])
			: '';

		return $instance;
	}
}
