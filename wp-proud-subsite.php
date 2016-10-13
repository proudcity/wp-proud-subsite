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

// Load Extendible
// -----------------------
if ( ! class_exists( 'ProudPlugin' ) ) {
  require_once( plugin_dir_path(__FILE__) . '../wp-proud-core/proud-plugin.class.php' );
}


class ProudSubsite extends \ProudPlugin {

  static $key = 'proud_subsite';

  public function __construct() {
    parent::__construct( array(
      'textdomain'     => 'wp-proud-subsite',
      'plugin_path'    => __FILE__,
    ) );

    add_filter( 'proud_submenu_parent_limit', array( $this, 'submenu_alter' ) );
    add_filter( 'proud_navbar_logo_url', array( $this, 'logo_url' ) );
    add_filter( 'proud_nav_action_toolbar', array( $this, 'action_toolbar' ) );
    add_filter( 'proud_nav_primary_menu', array( $this, 'navbar_primary_menu' ) );
  }

  /**
   *  Modify proud submenu call to allow for menus on normal pages
   *  ONLY if site origin is not active
   */
  public function submenu_alter( $depth, $category = false ) {
    global $proudcore;
    static $full_width;
    if(!isset($full_width)) {
      $full_width = $proudcore::$layout->post_is_full_width();
    }
    // Don't display submenu if we are top level and 
    // Site origins is active
    if( 0 === (int) $depth && $full_width) {
      return 0;
    }
    return 1;
  }


  /**
   *  Modify logo location
   */
  public function logo_url( $url ) {
    return get_option( 'parent_site', $url );
  }


  /**
   *  Modify toolbar
   */
  public function action_toolbar( $toolbar ) {
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/subsite-toolbar.php';
    $toolbar = ob_get_contents();
    ob_end_clean();
    return $toolbar;
  }


  /**
   *  Replace primary menu if setting exists
   */
  function navbar_primary_menu( $menu ) {
    $menu_option = get_option( 'proud_subsite_primary_menu', '' );
    if( $menu_option ) {
      ob_start();
      include plugin_dir_path(__FILE__) . 'templates/subsite-primary-menu.php';
      $toolbar = ob_get_contents();
      ob_end_clean();
      return $toolbar;
    }
    return $menu;
  }

}// class

$ProudSubsite = new ProudSubsite;