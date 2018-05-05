<?php

class Posts_wp {
	private $post_type = 'post';

	public function __construct()
	{
		add_action('add_meta_boxes', array($this, 'add_extra_fields_posts'), 1);
		add_action('save_post_post', array($this, 'save_extra_fields_posts'), 0);
		add_action( 'admin_print_footer_scripts', array( $this, 'show_assets' ), 10, 999 );
		add_action("the_content", array( $this, 'show_bottom_post_section' ));

	}
	public function add_extra_fields_posts()
	{
		add_meta_box( 'extra_fields', 'Extra posts parameters', array($this, 'extra_fields_box_func'), $this->post_type, 'normal', 'high'  );
	}
	public function extra_fields_box_func( $post )
	{

		?>
		<p class="box-title">Choose correct section</p>
		<select name="extra[section]">
			<?php $sel_v = get_post_meta(get_the_ID(), 'section', 1); ?>
			<option value="1" <?php selected( $sel_v, '1' )?> >Editorial</option>
			<option value="2" <?php selected( $sel_v, '2' )?> >Upfront</option>
			<option value="3" <?php selected( $sel_v, '3' )?> >In My View</option>
			<option value="4" <?php selected( $sel_v, '4' )?> >Feature</option>
			<option value="5" <?php selected( $sel_v, '5' )?> >In Practice</option>
		</select>
		<p>Do you want to attach this article to some issue? : <?php $mark_v = get_post_meta(get_the_ID(), 'attach', 1); ?>
			<label><input id="add_attachment" type="radio" name="extra[attach]" value="1" <?php checked( $mark_v, '1' ); ?> /> Yes</label>
			<label><input id="del_attachment" type="radio" name="extra[attach]" value="" <?php checked( $mark_v, '' ); ?> /> No</label>
		</p>
		<div class="attach-panel <?php echo ($mark_v == '1' ) ? 'filled' : 'unfilled' ?> ">
			<p>Issues list:</p>
			<select name="extra[select]">
			<?php $sel_v = get_post_meta(get_the_ID(), 'select', 1); ?>

			<?php
		$issues_list = new WP_Query(array('post_type' => 'issue', 'posts_per_page' => -1, 'order' => 'DESC'));
		if ( $issues_list->have_posts() ) :
			while ( $issues_list->have_posts()) : $issues_list->the_post();
				$id = get_post_thumbnail_id();
				$post_id = get_the_ID();
		?>
		<option value="<?php echo $post_id?>" <?php selected( $sel_v, $post_id )?> ><?php echo get_post_meta(get_the_ID(), 'number', 1) . ' - ' . get_the_title(); ?></option>
		<?php
		endwhile;
		endif;
		wp_reset_query();

//		$f = get_the_ID();
//		var_dump($f);
//		var_dump($_REQUEST['post']);
		?>
		</select>
		</div>
		<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
		<?php
	}
	public function save_extra_fields_posts( $post_id )
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
			.attach-panel {
			}
			.filled {
				display: block;
			}
			.unfilled {
				display: none;
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
				var add = $('#add_attachment');
				var del = $('#del_attachment');
				var attach_panel = $('.attach-panel');
				console.log(add);
				console.log(del);
				add.on("click",function () {
					attach_panel.addClass('filled');
					attach_panel.removeClass('unfilled');
				});
				del.on("click",function () {
					attach_panel.addClass('unfilled');
					attach_panel.removeClass('filled');
				});
			});
		</script>
		<?php
	}

	public function show_bottom_post_section($content)
	{
		if  (is_single() && get_post_type() == 'post' && (get_post_meta(get_the_ID(), 'attach', 1) == '1') ) {
			ob_start();
			require_once( dirname( __FILE__ ) . '/templates/post-footer.php' );
			$output = ob_get_clean();
			return $content . $output;
		} else {
			return $content;
		}
	}

}