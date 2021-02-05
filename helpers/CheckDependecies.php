<?php
// includes/Dependency_Checker.php

class HugedevsMarketingIntegration_Dependency_Checker_Helper {

	const REQUIRED_PLUGINS = array(
		'WooCommerce' => 'woocommerce/woocommerce.php',
	);

	public function check() {
		$missing_plugins = $this->get_missing_plugin_list();

		if ( ! empty( $missing_plugins ) ) {
			throw new Exception( implode(", ", $missing_plugins) );
		}
	}

	private function get_missing_plugin_list() {
		$missing_plugins = array_filter(
			self::REQUIRED_PLUGINS,
			array( $this, 'is_plugin_inactive' ),
			ARRAY_FILTER_USE_BOTH
		);

		return array_keys( $missing_plugins );
	}

	private function is_plugin_inactive( $main_plugin_file_path ) {
		return ! in_array( $main_plugin_file_path, $this->get_active_plugins() );
	}

	private function get_active_plugins() {
		return apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
	}

}