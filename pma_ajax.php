<?php

class Ajax_wp {
	public function __construct()
	{
		add_action('wp_ajax_nopriv_getFormTest', array($this, 'getFormTest'));
		add_action('wp_ajax_getFormTest', array($this, 'getFormTest'));
		add_action('wp_enqueue_scripts', array($this, 'addJS'));
	}
	function addJS(){
		wp_enqueue_script('getForm', plugins_url('/js/getFormData.js', __FILE__), array('jquery'), NULL, true);
		wp_localize_script('getForm', 'getdata_form', array(
			'ajax_url' => admin_url('admin-ajax.php')
		));
	}
	function getFormTest(){
		$count = $_POST['count'];
		$posts_list = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 3, 'offset' => $count, 'order' => 'DESC','tag' => 'blog'));
		if ( $posts_list->have_posts() ) :
			while ( $posts_list->have_posts()) : $posts_list->the_post();
				get_template_part('content', 'large');
			endwhile;
		endif;
		wp_reset_query();

		//var_dump($_POST);
		//echo 'TEST';
		wp_die();
	}
}
