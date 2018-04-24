<?php

class issue {
	public function __construct()
	{
		add_action('init', array($this, 'register_issue_type'));

		// подключаем функцию активации мета блока (my_extra_fields)
		add_action('add_meta_boxes', array($this, 'extra_fields_issues'));

	}
	public function register_issue_type() {
		register_post_type('issue', array(
			'label'  => null,
			'labels' => array(
				'name'               => 'Issues', // основное название для типа записи
				'singular_name'      => 'Issue', // название для одной записи этого типа
				'add_new'            => 'Add Issue', // для добавления новой записи
				'add_new_item'       => 'Add new Issue', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Edit Issue', // для редактирования типа записи
				'new_item'           => 'New Issue', // текст новой записи
				'view_item'          => 'View Issue', // для просмотра записи этого типа.
				'search_items'       => 'Search Issues', // для поиска по этим типам записи
				'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Not found in trash', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Issues', // название меню
			),
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => null, // зависит от public
			'exclude_from_search' => null, // зависит от public
			'show_ui'             => null, // зависит от public
			'show_in_menu'        => null, // показывать ли в меню адмнки
			'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
			'show_in_nav_menus'   => null, // зависит от public
			'show_in_rest'        => null, // добавить в REST API. C WP 4.7
			'rest_base'           => null, // $post_type. C WP 4.7
			'menu_position'       => 05,
			'menu_icon'           => 'dashicons-media-document',
			'capability_type'   => 'post',
			//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'        => false,
			'supports'            => array('title','editor','thumbnail','custom-fields'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => array('section'),
			'has_archive'         => true,
			'rewrite'             => true,
			'query_var'           => true,
		) );
	}

	public function extra_fields_issues() {
		add_meta_box( 'extra_fields', 'Extra fields', array($this, 'extra_fields_box_func'), 'issue', 'normal', 'high'  );
	}
	public function extra_fields_box_func( $issue ){
		?>
		<p><label><input type="text" name="extra[price]" value="<?php echo get_post_meta($issue->ID, 'price', 1); ?>" style="width:30%" /> Price </label></p>
		<p><label><input type="text" name="extra[date]" value="<?php echo get_post_meta($issue->ID, 'date', 1); ?>" style="width:30%" /> Data </label></p>

		<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
		<?php
	}
}

$issue = new issue();