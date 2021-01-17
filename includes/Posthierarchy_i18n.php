<?php

class Posthierarchy_i18n {
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'webdevhelper',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
