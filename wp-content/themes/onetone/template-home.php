<?php
/**
 * Template Name: Front Page
 *
 * @package Onetone
 */
get_header('home'); 
?>
<div class="post-wrap">
  <div class="container-fullwidth">
    <div class="page-inner row no-aside" style="padding-top: 0; padding-bottom: 0;">
      <div class="col-main">
        <section class="post-main" role="main" id="content">
<article class="page type-page homepage" role="article">
			<?php
			global $onetone_options,$onetone_new_version ,$onetone_animated,$onetone_home_sections;
							
			$detect = new Mobile_Detect;
			$video_background_section  = onetone_option( 'video_background_section' );
			$video_background_type     = onetone_option( 'video_background_type' );
			$video_background_type     = $video_background_type == ""?"youtube":$video_background_type;
			$section_1_content         = onetone_option( 'section_1_content' );
			$animated                  = onetone_option( 'home_animated');
			$section_1_content         = $section_1_content == 'slider'?1:$section_1_content;
			
			if( $animated == '1' || $animated == 'on' )
				$onetone_animated = 'onetone-animated';
						
			$new_homepage_section = array();
			
			$i = 1;
			foreach( $onetone_home_sections as $k => $v ){
			
				$section = onetone_option('section_order_'.$v['id']);
				if( $section !='' )
					$new_homepage_section[] = $section;
				else
					$new_homepage_section[] = $v['id'];
				$i++;
			}

			
			$i = 0 ;
			global $onetone_section_id;
			foreach( $new_homepage_section as $section_part ):
			
			$onetone_section_id = $section_part;
			
			$id = intval($section_part);
			
			$hide_section  = onetone_option( 'section_hide_'.$id );
						
			if( $hide_section != '1' && $hide_section != 'on' ){
				
				if( $id == 0 && ($section_1_content == '1' || $section_1_content == 'on' )){
		
					get_template_part('home-sections/section','slider');
					
					}else{
				//if( $video_background_section == $section_part && !$detect->isMobile() && !$detect->isTablet() )
				if( ($video_background_section-1) == $section_part  )
				   get_template_part('home-sections/section',$video_background_type.'-video');
				else
				   get_template_part('home-sections/section',intval($section_part));
				
				}
			
			}
			$i++;
			endforeach;
			?>
            <div class="clear"></div>
          </article>
        </section>
      </div>
    </div>
  </div>
</div>
<?php get_footer();?>