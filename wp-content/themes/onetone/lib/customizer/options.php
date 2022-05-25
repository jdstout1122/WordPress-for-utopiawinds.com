<?php
global $onetone_options_default;
$option_name   = onetone_option_name();
Mageewp::add_config( $option_name, array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'option',
	'option_name'   => $option_name
) );

$f = 1;
$p = 1;
$s = 1;
$section = '';
if(!$onetone_options_default)
	$options = onetone_theme_options();
else
	$options = $onetone_options_default;

$onetone_companion_options = get_option('onetone_companion_options');
if(!$onetone_companion_options){
	$onetone_companion_options = array();
}
if(class_exists('OnetoneCompanion') ){
	$onetone_companion_options = array_merge(OnetoneCompanion::default_options(),$onetone_companion_options);
}
$onetone_companion_options = apply_filters('onetone_companion_options',$onetone_companion_options);
$display = 1;
foreach($options as $key=>$option ){
	if($option['type']=='panel'){
		$display = 1;
		
		if( isset($onetone_companion_options[$option['slug']]) && $onetone_companion_options[$option['slug']] == '1'){
			
			$display = 0;
			}
	}
	
	if($display == 1){
		if($option['type']=='panel'){
		Mageewp::add_panel( $option['slug'], array(
		  'priority'    => $p,
		  'title'       => $option['label'],
		  'description' => '',
		  ) );
		  $p++;
		  $s = 1;
	}elseif($option['type']=='section'){
		
		Mageewp::add_section( $option['slug'], array(
		  'title'          => $option['label'],
		  'description'    => '',
		  'panel'          => $option['panel'], 
		  'priority'       => $s,
		  'capability'     => 'edit_theme_options',
		  'theme_supports' => '',
	  ) );
	  
	$section = $option['slug'];
	$s++;
	$f = 1;
	
	}else{
		
		$default = array(
		
			'choices'         => '',
			'row_label'       => '',
			'fields'          => '',
			'active_callback' => '',
			'transport'       => '',
			'output'          => '',
			'js_vars'         => '',
			'partial_refresh' => '',
			'description'     =>''
		
		);
		
		$option = array_merge($default, $option);
			
		Mageewp::add_field( $option_name, $option );
		
		$f++;
		
		}
	}
	
	}