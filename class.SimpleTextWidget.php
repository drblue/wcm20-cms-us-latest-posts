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
	 * @see WP_Widget::widget()
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
		echo "<p>{$instance['description']}</p>";

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
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = '';
		}

		// do we have a description set? if so, use it, otherwise set empty description
		if (isset($instance['description'])) {
			$description = $instance['description'];
		} else {
			$description = '';
		}

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

			<!-- description -->
			<p>
				<label for="<?php echo $this->get_field_id('description') ?>">Description:</label>

				<input
					class="widefat"
					id="<?php echo $this->get_field_id('description') ?>"
					name="<?php echo $this->get_field_name('description') ?>"
					type="text"
					value="<?php echo $description; ?>"
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

		$instance['description'] = (!empty($new_instance['description']))
			? strip_tags($new_instance['description'])
			: '';

		return $instance;
	}
}
