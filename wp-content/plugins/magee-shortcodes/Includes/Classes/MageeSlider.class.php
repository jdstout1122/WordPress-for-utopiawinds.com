<?php
namespace MageeShortcodes\Classes;

class MageeSlider{

	protected static $instance = null;
	
	public function __construct( $args = [] ) {
		add_action('init', array( $this, 'magee_slider_register') );
		add_action('admin_init', array( $this, 'magee_slider_init') );
		add_action('save_post', array( $this, 'magee_save_slide') );
		add_filter("manage_edit-magee_slider_columns", array( $this, "magee_slider_edit_columns"));
		add_action("manage_magee_slider_posts_custom_column", array( $this, "magee_slider_custom_columns"));
	}
		/**
	* Return an instance of this class.
	*
	* @return object A single instance of this class.
	*/
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	function magee_slider_register() {
	
	   $labels = array(
		   'name' => __('Magee Slider','magee-shortcodes'),
		   'singular_name' => 'Magee Slider',
		   'add_new_item' => __('Add New Slider','magee-shortcodes'),
		   'edit_item' => __('Edit Slider', 'magee-shortcodes'),
		   'new_item' => __('New Slider', 'magee-shortcodes'),
		   'view_item' => '',
		   'all_items' => 'All Sliders',
		   'search_items' => __('Search Slider', 'magee-shortcodes'),
		   'not_found' =>  __('Nothing found', 'magee-shortcodes'),
		   'not_found_in_trash' => __('Nothing found in Trash', 'magee-shortcodes'),
	   );
	
	   $args = array(
		   'labels' => $labels,
		   'public' => false,
		   'show_ui' => true,
		   'menu_icon' =>  MAGEE_SHORTCODES_URL. 'assets/images/menu-icon-slider.png',
		   'can_export' => true,
		   'exclude_from_search' => true,
		   'capability_type' => 'post',
		   'hierarchical' => false,
		   'menu_position' => 8,
		   'rewrite' => array('slug' => 'slider'),
		   'supports' => array('title')
		); 
		   
	   register_post_type( 'magee_slider' , $args );
	}
   
	function magee_slider_init(){
		add_meta_box("magee_slider_slides", __('Slides', 'magee-shortcodes'), array($this, "magee_slider_slides"), "magee_slider", "normal", "high");
	}
		
	function magee_slider_slides(){
		global $post;
		$custom = get_post_meta($post->ID);
		$slider = array();
		if(isset($custom["magee_custom_slider"]))
		$slider = json_decode( $custom["magee_custom_slider"][0],true );

		?>
   		<script>
	 	jQuery(document).ready(function($) {
			var nextCell = 0;
			$( "#magee-slider-items" ).sortable({placeholder: ".sort-item"});
   
			function magee_custom_slider_uploader(field) {
				var button = "#upload_"+field;
				jQuery(button).click(function() {
					window.restore_send_to_editor = window.send_to_editor;
					tb_show('', 'media-upload.php?referer=magee-settings&amp;type=image&amp;TB_iframe=true&amp;post_id=0');
					magee_set_slider_img(field);
					return false;
				});
		
			}
	   		function magee_set_slider_img(field) {
				window.send_to_editor = function(html) {
				imgurl = $('img', html).attr('src');
			   
				if(typeof imgurl == 'undefined') 
				   imgurl = $(html).attr('src');
				   
				classes = $('img', html).attr('class');
				if(typeof classes != 'undefined')
				   id = classes.replace(/(.*?)wp-image-/, '');
			   
				if(typeof classes == 'undefined'){ 
				   classes = $(html).attr('class');
				   if(typeof classes != 'undefined')
					   id = classes.replace(/(.*?)wp-image-/, '');
				}
				   
	   			$('#magee-slider-items').append('<li id="listItem_'+ nextCell +'" class="ui-state-default" style="margin-bottom:10px;"><div class="widget-content option-item" style="margin:5px; padding:5px;"><div class="slider-img"><img src="'+imgurl+'" alt=""></div><label for="magee_custom_slider['+ nextCell +'][title]"><span>Slide Title :</span><input id="magee_custom_slider['+ nextCell +'][title]" name="magee_custom_slider['+ nextCell +'][title]" value="" type="text" /></label><label for="magee_custom_slider['+ nextCell +'][caption]"><span style="float:left" >Slide Caption :</span><textarea name="magee_custom_slider['+ nextCell +'][caption]" id="magee_custom_slider['+ nextCell +'][caption]"></textarea></label><input id="magee_custom_slider['+ nextCell +'][id]" name="magee_custom_slider['+ nextCell +'][id]" value="'+id+'" type="hidden" /><a class="sort-item">Sort</a><a class="del-item">Delete</a><div class="clear"></div></div><div class="clear"></div></li>');
	  
				nextCell ++ ;
				tb_remove();
				window.send_to_editor = window.restore_send_to_editor;
			}
	   };
	   
		magee_custom_slider_uploader("add_slide");
	   
		$(document).on("click", ".del-item", function() {
			$(this).parent().parent().addClass('removered').fadeOut(function() {
				$(this).remove();
			});
		});
	   
	});
   
		</script>
		<div style="width:100%; height:30px; text-align:right; padding-top:10px;">
		<input  type="hidden" name="magee-custom-slider" value="1">
		<input id="upload_add_slide" type="button" class="options-save button-primary" value="Add New Slide"> 
		</div>
   
	   <ul id="magee-slider-items">
	   <?php
	   $i=0;
	   if( is_array($slider) ){
	   foreach( $slider as $slide ):
		   $i++; ?>
		   <li id="listItem_<?php echo $i ?>"  class="ui-state-default" style="margin-bottom:10px;">
			   <div class="widget-content option-item" style="margin:5px; padding:5px;">
				   <div class="slider-img"><?php echo wp_get_attachment_image( $slide['id'] , 'thumbnail' );  ?></div>
				   <label for="magee_custom_slider[<?php echo $i ?>][title]"><span><?php _e("Slide Title",'magee-shortcodes');?> :</span><input id="magee_custom_slider[<?php echo $i ?>][title]" name="magee_custom_slider[<?php echo $i ?>][title]" value="<?php  echo stripslashes( esc_attr($slide['title']) );  ?>" type="text" /></label>
				   
				   <label for="magee_custom_slider[<?php echo $i ?>][caption]"><span style="float:left" ><?php _e("Slide Caption",'magee-shortcodes');?> :</span><textarea name="magee_custom_slider[<?php echo $i ?>][caption]" id="magee_custom_slider[<?php echo $i ?>][caption]"><?php echo stripslashes(wp_kses_post($slide['caption']) ) ; ?></textarea></label>
				   <input id="magee_custom_slider[<?php echo $i ?>][id]" name="magee_custom_slider[<?php echo $i ?>][id]" value="<?php  echo $slide['id']  ?>" type="hidden" />
				   <a class="sort-item"><?php _e("Sort",'magee-shortcodes');?></a>
				   <a class="del-item"><?php _e("Delete",'magee-shortcodes');?></a>
				   <div class="clear"></div>
			   </div>
		   </li>
	   <?php endforeach; 
	   }else{
		   echo $custom['title0'];
		   echo $custom['title1'];
		   echo ' <p> '.__("Use the button above to add Slides !",'magee-shortcodes').'</p>';
	   }?>
	   </ul>
	   <div class="clear"></div>
	   <script> var nextCell = <?php echo $i+1 ?> ;</script>
   
		<?php
	}

	function magee_save_slide(){
		global $post;
		 
		if(isset($post->ID) && isset($_POST['magee-custom-slider'])) {
			if( isset($_POST['magee_custom_slider']) && $_POST['magee_custom_slider'] != "" ){
				foreach($_POST['magee_custom_slider'] as $pkey=>$attrs){
					foreach($attrs as $key => $val){
						switch($key){
						   case 'title':
						   $_POST['magee_custom_slider'][$pkey]['title'] = esc_attr($val);
						   break;
						   case 'caption':
						   $_POST['magee_custom_slider'][$pkey]['caption'] = wp_kses_post($val);
						   break;
						}
					}
				}
				$magee_custom_slider = json_encode($_POST['magee_custom_slider']);
				update_post_meta($post->ID, 'magee_custom_slider' , $magee_custom_slider);		
			} else {
			   //delete_post_meta($post->ID, 'magee_custom_slider' );
			}
		}
	}
	   
	
	function magee_slider_edit_columns($columns){
		$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __("Title",'magee-shortcodes'),
		"slides" => __("Number of Slides",'magee-shortcodes'),
		"date" => __("Date",'magee-shortcodes'),
		);
		return $columns;
	}
   
	function magee_slider_custom_columns($column){
		global $post;
		switch ($column) {
			case "slides":
				$magee_custom_slider_args = array( 'post_type' => 'magee_slider', 'p' => $post->ID );
				$magee_custom_slider = new \WP_Query( $magee_custom_slider_args );
				while ( $magee_custom_slider->have_posts() ) {
					$number =0;
					$magee_custom_slider->the_post();
					$custom = get_post_custom($post->ID);
					if( !empty($custom["magee_custom_slider"][0])){
						$slider = json_decode( $custom["magee_custom_slider"][0] ,true);
						echo $number = count($slider);
					}
					else echo 0;
				}
			break;
		}
	}

}
 
	
				