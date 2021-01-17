<?php

class CL7_Support {
	private $base_url;

	private $widget_visibility;
	private $widget_admin_area;

	public function __construct() {
		$this->widget_admin_area = get_option( 'cl7_feedback_widget_admin' );
		$this->widget_visibility = get_option( 'cl7_feedback_widget' );
	}

	public function feedback_widget() {
		if ( $this->widget_visibility == 'admin_only' && current_user_can( 'manage_option' ) )
			$this->_widget_script();
        elseif ( $this->widget_visibility == 'user_only' && is_user_logged_in() )
			$this->_widget_script();
        elseif ( $this->widget_visibility == 'public' )
			$this->_widget_script();
	}

	public function feedback_widget_admin() {
		if ( $this->widget_admin_area )
			$this->_widget_script();
	}

	private function _widget_script() {
		?>
        <script>
            Userback = window.Userback || {};
            Userback.access_token = '4370|5895|MoOd2NsoYZHdLXGG7ZqbkpIW34Gh2iDclylZh3KwaIuVLyEwjG';
            (function (id) {
                var s = document.createElement('script');
                s.async = 1;
                s.src = 'https://static.userback.io/widget/v1.js';
                var parent_node = document.head || document.body;
                parent_node.appendChild(s);
            })('userback-sdk');
        </script><?php
	}

}