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

    $this->hook( 'init', 'register_setting_pages' );
    add_filter( 'proud_submenu_parent_limit', array( $this, 'submenu_alter' ) );
    add_filter( 'proud_navbar_logo_url', array( $this, 'logo_url' ) );
    // Filter buttons
    add_filter( 'proud_nav_button_options', array( $this, 'nav_button_options' ), 10, 3 );
    $this->hook( 'proud_nav_toolbar_pre_buttons', 'nav_toolbar_pre_buttons' );
    add_filter( 'proud_nav_primary_menu', array( $this, 'navbar_primary_menu' ) );
  }


  /**
   * Register admin settings pages
   */ 
  public function register_setting_pages() {
    if( is_admin() ) {
      require_once( plugin_dir_path(__FILE__) . 'settings/subsite.php' );
    }
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
  public function nav_button_options( $options, $button, $display ) {
    $link_to_main = get_option( 'proud_subsite_link_toolbar_parent', [
      'payments' => 'payments',
      'report' => 'report'
    ] );
    // We're linking to main instead of standard
    if( !empty( $link_to_main[$button] ) ) {
      $href = get_option( 'proud_subsite_parent_site' );
      switch($button) {
        case 'answers':
          $href .= '/answers';
          break;
        case 'payments':
          $href .= '/payments';
          break;
        case 'report':
          $href .= '/issues';
          break;
        case 'search':
          $href .= '/search-site';
          break;
      }
      $options['data_key']= false;
      $options['href'] = $href;
      $options['classes'] .= ' same-window';
    }
    return $options;
  }

  /**
   *  Insert home link
   */
  public function nav_toolbar_pre_buttons() {
    if( !get_option( 'proud_subsite_primary_menu' ) && !get_option( 'proud_subsite_hide_main_btn' ) ) {
      $parent_url = get_option( 'proud_subsite_parent_site' );
      include plugin_dir_path(__FILE__) . 'templates/subsite-toolbar.php';
    }
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

new ProudSubsite;