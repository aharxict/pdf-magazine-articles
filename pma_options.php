<?php


class Options {

	public function __construct()
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'load_plugin_css' ) );
	}
	public function load_plugin_css()
	{
		$plugin_url = plugin_dir_url( __FILE__ );

		wp_enqueue_style( 'style', $plugin_url . 'css/style.css' );
	}
}