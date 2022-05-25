<?php
/*
  Plugin Name: Magee Shortcodes
  Plugin URI: https://www.hoosoft.com/plugins/magee-shortcodes/
  Description: Magee Shortcodes is WordPress plugin that provides a pack of shortcodes. With Magee Shortcodes, you can easily create accordion, buttons, boxes, columns, social and much more. They allow you to create so many different page layouts. You could quickly and easily built your own custom pages using all the various shortcodes that Magee Shortcodes includes.
  Version: 2.1.0
  Author: Hoosoft
  Author URI: http://www.hoosoft.com
  Text Domain: magee-shortcodes
  Domain Path: /languages
  License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) return;

  $plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
  $plugin_version = $plugin_data['Version'];
  define( 'MAGEE_SHORTCODES_DIR_PATH',  plugin_dir_path( __FILE__ ));
  define( 'MAGEE_SHORTCODES_INCLUDE_DIR', MAGEE_SHORTCODES_DIR_PATH.'Includes' );
  define( 'MAGEE_SHORTCODES_URL',  plugin_dir_url( __FILE__ ));
  define( 'MAGEE_SHORTCODES_VER', $plugin_version );
  define('MAGEE_PORTFOLIO', 'magee_portfolio' );
  define( 'MAGEE_DATE_FORMAT', '');
  define( 'MAGEE_DISPLAY_IMAGE', 'yes');
  define( 'MAGEE_PORTFOLIO_SLUG', 'portfolio');
  define( 'MAGEE_EXCERPT_OR_CONTENT', 'excerpt');
  define( 'MAGEE_EXCERPT_LENGTH', 55);

  require_once MAGEE_SHORTCODES_INCLUDE_DIR.'/plugin.php';