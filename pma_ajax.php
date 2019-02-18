<?php

class Ajax_wp {
	public function __construct()
	{
		add_action('wp_ajax_nopriv_getFormTest', array($this, 'getFormTest'));
		add_action('wp_ajax_getFormTest', array($this, 'getFormTest'));
		add_action('wp_ajax_nopriv_getBlog', array($this, 'getBlog'));
		add_action('wp_ajax_getBlog', array($this, 'getBlog'));
		add_action('wp_ajax_nopriv_getMoreBlogPosts', array($this, 'getMoreBlogPosts'));
		add_action('wp_ajax_getMoreBlogPosts', array($this, 'getMoreBlogPosts'));
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
		$actual_posts_counter = $count;

		$query_array = $this->create_filter_query('3','blog');

//		$posts_list = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 3, 'offset' => $count, 'order' => 'DESC','tag' => 'blog'));
		$posts_list = new WP_Query($query_array);
		if ( $posts_list->have_posts() ) :
			while ( $posts_list->have_posts()) : $posts_list->the_post();
				get_template_part('content', 'large');
				$actual_posts_counter = $actual_posts_counter + 1;
			endwhile;
		endif;
		wp_reset_query();
		$this->load_more_control($actual_posts_counter,'blog');

		//var_dump($_POST);
		//echo 'TEST';
		wp_die();
	}
	function create_filter_query($posts_per_page, $tag = '0') {

		$issue_number = $_POST['issue_number'];
		$post_section = $_POST['post_section'];
		$sort_date = $_POST['sort_date'];
		$count = $_POST['count'];

		//echo $count;
		$query_array = array(
			'post_type' => 'post',
			'posts_per_page' => $posts_per_page,
			'offset' => $count
		);
		if ((!$issue_number == '0') && (!$post_section == '0')) {
			$number_query = array(
				array(
					'key'     => 'attach',
					'value'   => '1',
				),
				array(
					'key'     => 'select',
					'value'   => $issue_number,
				),
				array(
					'key'     => 'section',
					'value'   => $post_section,
				)
			);
			$query_array['meta_query'] = $number_query;
		} elseif (($issue_number == '0') && (!$post_section == '0')) {
			$number_query = array(
				array(
					'key'     => 'section',
					'value'   => $post_section,
				)
			);
			$query_array['meta_query'] = $number_query;
		} elseif ((!$issue_number == '0') && ($post_section == '0')) {
			$number_query = array(
				array(
					'key'     => 'attach',
					'value'   => '1',
				),
				array(
					'key'     => 'select',
					'value'   => $issue_number,
				)
			);
			$query_array['meta_query'] = $number_query;
		}

		if ($sort_date == '2') {
			$query_array['order'] = 'ASC';
		} else {
			$query_array['order'] = 'DESC';
		}
		if (!$tag == '0') {
			$query_array['tag'] = $tag;
		}
		return $query_array;
	}
	function getMoreBlogPosts(){

//		$count = $_POST['count'];
//		$issue_number = $_POST['issue_number'];
//		$post_section = $_POST['post_section'];
//		$sort_date = $_POST['sort_date'];
//		if ($sort_date == '2') {
//			$sort_date = 'ASC';
//		} else {
//			$sort_date = 'DESC';
//		}
		$query_array = $this->create_filter_query('3');

		$posts_list = new WP_Query($query_array);
		$actual_posts_counter = $_POST['count'];
		if ( $posts_list->have_posts() ) :
			while ( $posts_list->have_posts()) : $posts_list->the_post();
				get_template_part('content', 'loop');
				$actual_posts_counter = $actual_posts_counter + 1;
			endwhile;
		endif;
		wp_reset_query();
		$this->load_more_control($actual_posts_counter);
		//var_dump($_POST);
		//echo 'TEST';
		wp_die();
	}
	function getBlog(){

		$query_array = $this->create_filter_query('3');

		$posts_list = new WP_Query($query_array);
//		$posts_list = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 10, 'order' => $sort_date,
//				 'meta_query' => array(
//				     array(
//				         'key'     => 'attach',
//				         'value'   => '1',
//				     ),
//				     array(
//				         'key'     => 'select',
//				         'value'   => $issue_number,
//				     )
//				 )));
		$actual_posts_counter = 0;
		if ( $posts_list->have_posts() ) :
			while ( $posts_list->have_posts()) : $posts_list->the_post();
				get_template_part('content', 'loop');
				$actual_posts_counter = $actual_posts_counter + 1;
			endwhile;
		endif;

		wp_reset_query();
		//var_dump($_POST);
		//echo 'TEST';
		$this->load_more_control($actual_posts_counter);
		wp_die();
	}
	function post_count($tag='0') {
		$all_query_array = $this->create_filter_query('-1',$tag);
		$all_posts_list = new WP_Query($all_query_array);
		$posts_counter = 0;
		if ( $all_posts_list->have_posts() ) :
			while ( $all_posts_list->have_posts()) : $all_posts_list->the_post();
				$posts_counter = $posts_counter + 1;
			endwhile;
		endif;
		wp_reset_query();
		return $posts_counter;
	}
	function load_more_control($actual_posts_counter, $tag='0'){
		$general_post_quantity = $this->post_count($tag);
		//echo $general_post_quantity;
		//echo '<br>';
		//echo $actual_posts_counter;
		?>
		<script>
			(function ($) {
				var blog_load_more = $('#blog-load-more');
				var load_more =$('#load-more');
				<?php if ($general_post_quantity - $actual_posts_counter > 0) { ?>
				blog_load_more.css('display', 'block');
				load_more.css('display', 'block');
				console.log('more');
				<?php } elseif ($general_post_quantity - $actual_posts_counter == 0) { ?>
				blog_load_more.css('display', 'none');
				load_more.css('display', 'none');
				console.log('none');
				<?php }?>
			})(jQuery);
		</script>
		<?php
	}
}
