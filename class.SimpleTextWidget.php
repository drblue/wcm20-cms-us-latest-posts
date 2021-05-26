<?php

class SimpleTextWidget extends WP_Widget {

	/**
	 * Construct a new widget instance.
	 */
	public function __construct() {
		parent::__construct(
			'wcm20-latestposts-simpletextwidget', // Base ID
			'Simple Text Widget', // Name
		);
	}

	/**
	 * Front-end display of the widget.
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved option values for this specific instance of the widget.
	 * @return void
	 */
	public function widget($args, $instance) {
		/**
			Args:
				[name] => Sidebar
				[id] => sidebar-1
				[description] => Add widgets here.
				[class] =>
				[before_widget] => <section id="wcm20-latestposts-simpletextwidget-2" class="widget widget_wcm20-latestposts-simpletextwidget card card-body mb-4 bg-light border-0">
				[after_widget] => </section>
				[before_title] => <h2 class="widget-title card-title border-bottom py-2">
				[after_title] => </h2>
				[before_sidebar] =>
				[after_sidebar] =>
				[widget_id] => wcm20-latestposts-simpletextwidget-2
				[widget_name] => Simple Text Widget
			Instance:
				[]
		 */

		// start widget
		echo $args['before_widget'];

		// render title
		if (!empty($instance['title'])) {
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		}

		// render content
		echo "<p>Here be content (in the future)!</p>";

		// end widget
		echo $args['after_widget'];
	}
}
