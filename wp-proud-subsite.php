<?php
/*
Plugin Name:        Proud Subsite
Plugin URI:         http://getproudcity.com
Description:        ProudCity distribution
Version:            1.0.0
Author:             ProudCity
Author URI:         http://getproudcity.com

License:            Affero GPL v3
*/

require_once( plugin_dir_path(__FILE__) . 'settings/subsite.php' );

/**
 *  Active navbar, so edit body class
 */
function proud_subsite_logo_url( $url ) {
  return get_option( 'proud_subsite_parent_site', $url );
}
add_filter( 'proud_navbar_logo_url', 'proud_subsite_logo_url' );

/**
 *  Active navbar, so edit body class
 */
function proud_subsite_action_toolbar( $toolbar ) {
  ob_start();
  include plugin_dir_path(__FILE__) . 'templates/subsite-toolbar.php';
  $toolbar = ob_get_contents();
  ob_end_clean();
  return $toolbar;
}
add_filter( 'proud_nav_action_toolbar', 'proud_subsite_action_toolbar' );

/**
 *  Active navbar, so edit body class
 */
function proud_subsite_primary_menu( $menu ) {
  return get_option( 'proud_subsite_primary_menu', false );
}
add_filter( 'proud_nav_primary_menu', 'proud_subsite_primary_menu' );
