<?php
class wildfire_contact_details extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'wildfire_contact_details',
			__( 'Contact Details', 'wildfire' ),
			array(
				'classname'   => 'wildfire_contact_details',
			)
		);

	}

	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		?>
		<div class="footer-address">
		<h6><?php echo $args['wildfire_title']; ?></h6>
		<p><?php echo $args['wildfire_address']; ?></p>
		<ul>
		<li>
		<i class="fa fa-phone"></i> 
		<span>Phone: <?php echo $args['wildfire_phone']; ?></span>
		</li>
		<li>
		<i class="fa fa-envelope-o"></i> 
		<span>Email : <a href="mailto:<?php echo $args['wildfire_email']; ?>"><?php echo $args['wildfire_email']; ?></a></span>
		</li>
		</ul>
		</div>
		</div>
		<?php
		echo $args['after_widget'];

	}

	public function form( $instance ) {

		// Set default values
		$instance = wp_parse_args( (array) $instance, array( 
			'wildfire_title' => '',
			'wildfire_address' => '',
			'wildfire_phone' => '',
			'wildfire_mobile' => '',
			'wildfire_email' => '',
			'wildfire_second_email' => '',
		) );

		// Retrieve an existing value from the database
		$wildfire_title = !empty( $instance['wildfire_title'] ) ? $instance['wildfire_title'] : '';
		$wildfire_address = !empty( $instance['wildfire_address'] ) ? $instance['wildfire_address'] : '';
		$wildfire_phone = !empty( $instance['wildfire_phone'] ) ? $instance['wildfire_phone'] : '';
		$wildfire_mobile = !empty( $instance['wildfire_mobile'] ) ? $instance['wildfire_mobile'] : '';
		$wildfire_email = !empty( $instance['wildfire_email'] ) ? $instance['wildfire_email'] : '';
		$wildfire_second_email = !empty( $instance['wildfire_second_email'] ) ? $instance['wildfire_second_email'] : '';

		// Form fields
		echo '<p>';
		echo '	<label for="' . $this->get_field_id( 'wildfire_title' ) . '" class="wildfire_title_label">' . __( 'Location Title', 'wildfire' ) . '</label>';
		echo '	<input type="text" id="' . $this->get_field_id( 'wildfire_title' ) . '" name="' . $this->get_field_name( 'wildfire_title' ) . '" class="widefat" placeholder="' . esc_attr__( 'eg: Head Office', 'wildfire' ) . '" value="' . esc_attr( $wildfire_title ) . '">';
		echo '</p>';

		echo '<p>';
		echo '	<label for="' . $this->get_field_id( 'wildfire_address' ) . '" class="wildfire_address_label">' . __( 'Address', 'wildfire' ) . '</label>';
		echo '	<textarea id="' . $this->get_field_id( 'wildfire_address' ) . '" name="' . $this->get_field_name( 'wildfire_address' ) . '" class="widefat" placeholder="' . esc_attr__( '', 'wildfire' ) . '">' . $wildfire_address . '</textarea>';
		echo '</p>';

		echo '<p>';
		echo '	<label for="' . $this->get_field_id( 'wildfire_phone' ) . '" class="wildfire_phone_label">' . __( 'Phone', 'wildfire' ) . '</label>';
		echo '	<input type="text" id="' . $this->get_field_id( 'wildfire_phone' ) . '" name="' . $this->get_field_name( 'wildfire_phone' ) . '" class="widefat" placeholder="' . esc_attr__( '', 'wildfire' ) . '" value="' . esc_attr( $wildfire_phone ) . '">';
		echo '</p>';

		echo '<p>';
		echo '	<label for="' . $this->get_field_id( 'wildfire_mobile' ) . '" class="wildfire_mobile_label">' . __( 'Second Phone', 'wildfire' ) . '</label>';
		echo '	<input type="text" id="' . $this->get_field_id( 'wildfire_mobile' ) . '" name="' . $this->get_field_name( 'wildfire_mobile' ) . '" class="widefat" placeholder="' . esc_attr__( '', 'wildfire' ) . '" value="' . esc_attr( $wildfire_mobile ) . '">';
		echo '</p>';

		echo '<p>';
		echo '	<label for="' . $this->get_field_id( 'wildfire_email' ) . '" class="wildfire_email_label">' . __( 'Email', 'wildfire' ) . '</label>';
		echo '	<input type="email" id="' . $this->get_field_id( 'wildfire_email' ) . '" name="' . $this->get_field_name( 'wildfire_email' ) . '" class="widefat" placeholder="' . esc_attr__( '', 'wildfire' ) . '" value="' . esc_attr( $wildfire_email ) . '">';
		echo '</p>';

		echo '<p>';
		echo '	<label for="' . $this->get_field_id( 'wildfire_second_email' ) . '" class="wildfire_second_email_label">' . __( 'Second Email', 'wildfire' ) . '</label>';
		echo '	<input type="email" id="' . $this->get_field_id( 'wildfire_second_email' ) . '" name="' . $this->get_field_name( 'wildfire_second_email' ) . '" class="widefat" placeholder="' . esc_attr__( '', 'wildfire' ) . '" value="' . esc_attr( $wildfire_second_email ) . '">';
		echo '</p>';

	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['wildfire_title'] = !empty( $new_instance['wildfire_title'] ) ? strip_tags( $new_instance['wildfire_title'] ) : '';
		$instance['wildfire_address'] = !empty( $new_instance['wildfire_address'] ) ? strip_tags( $new_instance['wildfire_address'] ) : '';
		$instance['wildfire_phone'] = !empty( $new_instance['wildfire_phone'] ) ? strip_tags( $new_instance['wildfire_phone'] ) : '';
		$instance['wildfire_mobile'] = !empty( $new_instance['wildfire_mobile'] ) ? strip_tags( $new_instance['wildfire_mobile'] ) : '';
		$instance['wildfire_email'] = !empty( $new_instance['wildfire_email'] ) ? strip_tags( $new_instance['wildfire_email'] ) : '';
		$instance['wildfire_second_email'] = !empty( $new_instance['wildfire_second_email'] ) ? strip_tags( $new_instance['wildfire_second_email'] ) : '';

		return $instance;

	}

}

function wildfire_register_widgets() {
	register_widget( 'wildfire_contact_details' );
}
add_action( 'widgets_init', 'wildfire_register_widgets' );