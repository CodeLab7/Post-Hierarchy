<?php

class CL7_Settings extends Posthierarchy_Abstruct {

	private $page_name = 'Codelab7 Support';
	private $page_id = 'cl7_support';
	private $group_id = 'cl7_support_';

	public function init_settings() {
		add_settings_section( 'tools', 'Tools', false, $this->page_id );
		register_setting( $this->group_id, 'cl7_feedback_widget' );
		register_setting( $this->group_id, 'cl7_feedback_widget_admin' );
		add_settings_field( 'cl7_feedback_widget', 'Enable Feedback widget:', [ $this, 'render_feedback_widget' ], $this->page_id, 'tools' );
	}

	public function render_feedback_widget() {
		$value = get_option('cl7_feedback_widget');
		$admin_enable = get_option('cl7_feedback_widget_admin');
		?>
        <select name="cl7_feedback_widget" id="cl7_feedback_widget">
            <option value="disable" <?php selected($value, 'disable'); ?>>Disable</option>
            <option value="admin_only" <?php selected($value, 'admin_only'); ?>>Admin Only</option>
            <option value="user_only" <?php selected($value, 'user_only'); ?>>Logged-in User Only</option>
            <option value="public" <?php selected($value, 'public'); ?>>Publicly on website</option>
        </select>
        &nbsp;
        <label><input type="checkbox" name="cl7_feedback_widget_admin" value="1" <?= ($admin_enable==1)? 'checked' : '' ?>>Also show in admin area</label>
		<?php
	}

	public function add_setting_page() {
		add_submenu_page( 'index.php', $this->page_name, $this->page_name, 'manage_options', $this->page_id, array( $this, 'page_layout' ), 5 );
	}

	public function page_layout() {
		// Check required user capability
		if ( ! current_user_can( 'manage_options' ) )
			wp_die( 'You do not have sufficient permissions to access this page.' );
		$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'tools';
		?>
        <!-- Create a header in the default WordPress 'wrap' container -->
        <div class="wrap">
            <h1><?= get_admin_page_title(); ?></h1>
			<?php settings_errors(); ?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=cl7_support&tab=tools" class="nav-tab <?php echo $active_tab == 'tools' ? 'nav-tab-active' : ''; ?>">Tools</a>
                <a href="?page=cl7_support&tab=help" class="nav-tab <?php echo $active_tab == 'help' ? 'nav-tab-active' : ''; ?>">Help</a>
            </h2>

			<?php if ( $active_tab == 'tools' ): ?>
                <form method="post" action="options.php">
					<?php settings_fields( $this->group_id ); ?>
					<?php do_settings_sections( $this->page_id ); ?>
					<?php submit_button(); ?>
                </form>
			<?php else: ?>
                <div class="card">
                    <h2>Codelab7 Support</h2>
                    <p> We provide all kind of services in wordpress.<br/>
                    For More Information Visit: <a href="https://codelab7.com" target="_blank">Codelab7</a> </p>
                </div>
			<?php endif; ?>


        </div><!-- /.wrap -->
		<?php
	}

}