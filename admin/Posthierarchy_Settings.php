<?php

class Posthierarchy_Settings extends Posthierarchy_Abstruct {

	private $page_name;
	private $page_id;
	private $options;
	private $sections;
	private $active_section;
	private $group_id;

	public function __construct( $page_name ) {
		$this->page_name = $page_name;
		$this->page_id   = $this->_clean_varname( $page_name );
		$this->group_id  = $this->page_id;
	}

	public function add_option( $option_name, $type, $description = '' ) {
		$option_id = $this->group_id . '_' . $this->_clean_varname( $option_name, '_' );
		if ( ! $description ) {
			$description = "Setting will be provided with name: <code>" . $option_id . "</code>";
		}
		$this->options[] = array(
			'id'          => $option_id,
			'title'       => $option_name,
			'type'        => $type,
			'description' => $description,
			'section_id'  => $this->active_section
		);
	}

	public function add_section( $section_name ) {
		$this->sections[]     = [
			'title' => $section_name,
			'id'    => $this->_clean_varname( $section_name )
		];
		$this->active_section = $this->_clean_varname( $section_name );
	}

	public function init_settings() {
		//Register new section
		foreach ( $this->sections as $section ) {
			add_settings_section( $section['id'], $section['title'], false, $this->page_id );
		}

		//Multiple setting fields
		foreach ( $this->options as $option ) {
			register_setting( $this->group_id, $option['id'], array( 'type' => $option['type'] ) );
			add_settings_field( $option['id'], $option['title'], array( $this, 'render_field' ), $this->page_id, $option['section_id'], $option );
		}

	}

	public function render_field( $args ) {
		$value = get_option( $args['id'] );
		switch ( $args['type'] ) {
			case 'textarea':
				echo '<textarea name="' . $args['id'] . '" class="regular-text" >' . esc_attr( $value ) . '</textarea>';
				echo '<p class="description">' . $args['description'] . '</p>';
				break;
			case 'password':
				echo '<input type="password" name="' . $args['id'] . '" class="regular-text"  value="' . esc_attr( $value ) . '">';
				echo '<p class="description">' . $args['description'] . '</p>';
				break;
			case 'checkbox':
				$checked = esc_attr( $value ) ? 'checked' : '';
				echo '<input type="checkbox" name="' . $args['id'] . '" value="true"' . $checked . '>';
				echo '<p class="description">' . $args['description'] . '</p>';
				break;
			default :
				echo '<input type="text" name="' . $args['id'] . '" class="regular-text" value="' . esc_attr( $value ) . '">';
				echo '<p class="description">' . $args['description'] . '</p>';
				break;
		}
	}

	public function add_setting_page() {
		add_options_page( $this->page_name . '\'s Settings', $this->page_name, 'manage_options', $this->page_id, array( $this, 'page_layout' ), 1 );
	}

	public function page_layout() {
		// Check required user capability
		if ( ! current_user_can( 'manage_options' ) )
			wp_die( 'You do not have sufficient permissions to access this page.' );

		// Admin Page Layout
		echo '<div class="wrap">';
		echo '<h1>' . get_admin_page_title() . '</h1>';
		echo '<form action="options.php" method="post">';

		settings_fields( $this->group_id );
		do_settings_sections( $this->page_id );
		submit_button();
		echo '</form>';
		echo '</div>';
	}

}