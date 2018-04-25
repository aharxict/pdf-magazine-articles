<?php

class Issue {

	private $post_type = 'issue';

	public function __construct()
	{
		add_action('init', array($this, 'register_issue_type'));
		// подключаем функцию активации мета блока (my_extra_fields)
		add_action('add_meta_boxes', array($this, 'add_extra_fields_issues'), 1);
		add_action('save_post_issue', array($this, 'save_extra_fields_issues'), 0);
		add_action( 'admin_print_footer_scripts', array( $this, 'show_assets' ), 10, 999 );
	}
	public function register_issue_type()
	{
		register_post_type($this->post_type, array(
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

	public function add_extra_fields_issues()
	{
		add_meta_box( 'extra_fields', 'Extra issue parameters', array($this, 'extra_fields_box_func'), $this->post_type, 'normal', 'high'  );
	}
	public function extra_fields_box_func( $issue )
	{
		?>
		<p class="box-title">Choose correct section</p>
		<select name="extra[select]">
				<?php $sel_v = get_post_meta(get_the_ID(), 'select', 1); ?>
				<option value="1" <?php selected( $sel_v, '1' )?> >Editorial</option>
				<option value="2" <?php selected( $sel_v, '2' )?> >Upfront</option>
				<option value="3" <?php selected( $sel_v, '3' )?> >In My View</option>
				<option value="4" <?php selected( $sel_v, '4' )?> >Feature</option>
				<option value="5" <?php selected( $sel_v, '5' )?> >In Practice</option>
		</select>
		<?php
//		$f = get_the_ID();
//		var_dump($f);
//		var_dump($_REQUEST['post']);
		?>

		<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
		<?php
	}
	public function save_extra_fields_issues( $post_id )
	{
//		if ( ! wp_verify_nonce( $_POST['extra_fields_nonce'], __FILE__ ) ) {
//			return false;
//		} // проверка
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		} // выходим если это автосохранение
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return false;
		} // выходим если юзер не имеет право редактировать запись
		if ( ! isset( $_POST['extra'] ) ) {
			return false;
		} // выходим если данных нет

		// Все ОК! Теперь, нужно сохранить/удалить данные
		$_POST['extra'] = array_map( 'trim', $_POST['extra'] ); // чистим все данные от пробелов по краям
		foreach ( $_POST['extra'] as $key => $value ) {
			if ( empty( $value ) ) {
				delete_post_meta( $post_id, $key ); // удаляем поле если значение пустое
				continue;
			}
			update_post_meta( $post_id, $key, $value ); // add_post_meta() работает автоматически
		}

		return $post_id;
	}

	public function show_assets()
	{
		if ( is_admin() && get_current_screen()->id == $this->post_type ) {
			$this->show_styles();
			$this->show_scripts();
		}
	}
	## Выводит на экран стили
	public function show_styles()
	{
		?>
		<style>
			.box-title {
				font-size: 18px;
			}
		</style>
		<?php
	}

	## Выводит на экран JS
	public function show_scripts()
	{
		?>
		<script>
			jQuery(document).ready(function ($) {

			});
		</script>
		<?php
	}

}